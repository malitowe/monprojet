<?php


namespace App\Controller;


use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Enseignant;
use App\Entity\Etablissement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashController extends AbstractController
{
    /**
     * @Route("/espace-client", name="pageutilisateur")
     */
    public function showHome()
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_login');
        }
        $enseignant = NULL;
        $etudiant  = NULL;
        if($user instanceof Etudiant){
            $etudiant = $user;
        }
        if($user instanceof Enseignant){
            $enseignant = $user;
        }
        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'enseignant' => $enseignant,
            'etudiant' => $etudiant
        ]);
    }

    /**
     * @Route("/espace-client/profile", name="my-profile")
     */
    public function showProfile()
    {
        return $this->render('dashboard/profile.html.twig', [
        ]);
    }

    /**
     * @Route("/espace-client/cours", name="espace-prive-cours")
     */
    public function showCours()
    {
        $em = $this->getDoctrine()->getManager();
        $enseignant = NULL;
        $etudiant  = NULL;
        $cours = NULL;
        $user = $this->getUser();
        if($user->getTypeUser() == "etudiant"){
            $etudiant = $user;
            $cours = $em->getRepository(Cours::class)->findAll();
            //dump($cours);
        }
        if($user->getTypeUser() == "enseignant"){
            $enseignant = $user;
            $cours = $em->getRepository(Cours::class)->findBy(array('created_by' => $enseignant));
        }
        //dump($user);die;
        return $this->render('dashboard/cours.html.twig', [
            'classes' => $em->getRepository(Classe::class)->findAll(),
            'cours' => $cours
        ]);
    }

    /**
     * @Route("/espace-client/classe", name="espace-prive-classe")
     */
    public function showClasse()
    {
        $em = $this->getDoctrine()->getManager();
        $enseignant = $this->getUser();
        $classes = $em->getRepository(Classe::class)->findBy(array('added_by' => $enseignant));
        return $this->render('dashboard/classe.html.twig', [
            'schools' => $em->getRepository(Etablissement::class)->findAll(),
            'classes' => $classes
        ]);
    }
    /**
     * @Route("/espace-client/classe/creation", name="espace-prive-classe-creation")
     */
    public function showCreation(request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $data = $request->request->get("classe");
            $classe = new Classe();

            $etablissement = $em->getRepository(Etablissement::class)->find((int)$data['etablissement']);
            $classe->setEtablissement($etablissement);
            $classe->setLibelle($data['nom']);
            $classe->setUpdatedAt(new \DateTime());
            $classe->setCreatedAt(new \DateTime());
            $enseignant = $this->getUser();

            $classe->setAddedBy($enseignant);
            $em->persist($classe);
            $em->flush();
            $this->addFlash("success", "Classe enregistrée");

        }
        return $this->render('dashboard/creationclasse.html.twig', []);
    }


    /**
     * @Route("/espace-client/cours/creation", name="espace-prive-cours-creation")
     */
    public function showCreationcours(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST'){
           $data =  $request->request->get("cours");
           $cours = new Cours();
           $cours->setCreatedAt(new \DateTime());
           $cours->setUpdatedAt(new \DateTime());
           $cours->setCode($data['code']);
           $cours->setStatus(1);
           $cours->setLibelle($data['nom']);
           $cours->setDescription($data['description']);
           $enseignant = $this->getUser();
           $cours->setCreatedBy($enseignant);
           $em->persist($cours);
           $em->flush();
           $this->addFlash("success", "cours enregistré");
        }
        return $this->redirectToRoute('espace-prive-cours');
    }

    /**
    *@Route("/course/{id}", name="course_start")
    */
    public function conference(Cours $cours)
    {
        $user = $this->getUser();
        return $this->render('websocket/conference.html.twig', [
            'controller_name' => 'WebsocketController',
            'libelle'=>$cours->getLibelle(),
            'username'=>$user->getUsername()
        ]);
    }

    /**
    *@Route("/course/{id}/update", name="course_update")
    */
    public function courseUpdate(Request $request, Cours $cours)
    {

        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST'){
            $code = $request->request->get("json");
            $course_code = json_encode(json_decode($code)->room);
            $course_code = str_replace('"', '', $course_code);
            $course = $em->getRepository(Cours::class)->findOneBy(['id'=>$cours->getId()]);
            $course->setCode($course_code);
            $course->setStatus(1);
            $em->persist($course);
            $em->flush();
            $response = "Cours Démarré";
            return new JsonResponse($response); 
        }
    }
}
