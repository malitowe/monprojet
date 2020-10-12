<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class WebsocketController extends AbstractController
{
    /**
     * @Route("/websocket", name="websocket")
     */
    public function index()
    {
        return $this->render('websocket/index.html.twig', [
            'controller_name' => 'WebsocketController',
        ]);
    }

    /**
    *@Route("/iceServer", name="iceserver")
    */
    public function indexIce()
    {
        $servers = $this->getIceServers();

        header('Content-Type: Application/json');
        return new JsonResponse(json_encode(json_decode($servers)->v->iceServers));
    }


    private function getIceServers()
    {
        // PHP Get ICE STUN and TURN list
        $data = array( "format" => "urls" );
        $data_json = json_encode($data);

        $curl = curl_init();
        curl_setopt_array( $curl, array (
              CURLOPT_HTTPHEADER => array("Content-Type: application/json","Content-Length: " . strlen($data_json)),
              CURLOPT_POSTFIELDS => $data_json,
              CURLOPT_URL => "https://global.xirsys.net/_turn/MyFirstWebRTC",
              CURLOPT_USERPWD => "LacEinstein:fe5f2d2a-0ac6-11eb-b9ea-0242ac150002",
              CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0
        ));

        $resp = curl_exec($curl);
        if(curl_error($curl)){
              echo "Curl error: " . curl_error($curl);
        };
        curl_close($curl);
        return $resp;
    }
}
