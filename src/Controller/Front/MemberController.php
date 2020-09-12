<?php


namespace App\Controller\Front;


use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Util\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class MemberController extends AbstractController
{

    /**
     * @Route("/inscription", name="user_register")
     */
    public function createUser(Request $request, EncoderFactoryInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == "POST"){
            $tokenGenerator = new TokenGenerator();
            $data = $request->request->get("user");

            if ($data['typeuser'] == "etudiant"){
                $user = new Etudiant();
                $user->setTypeUser('etudiant');
            }elseif ($data['typeuser'] == "enseignant"){
                $user = new Enseignant();
                $user->setTypeUser('enseignant');
            }
            $user->setActive(1);
            $user->setCreatedAt(new \DateTime());
            $user->setNom($data['last_name']);
            $user->setPrenom($data['first_name']);
            $user->setConfirmationToken($tokenGenerator->generateToken());
            $user->setSexe($data['gender']);
            $user->setUsername($data['email']);
            $user->setEmail($data['email']);
            $user->setUpdatedAt(new \DateTime());
            $em->persist($user);


            if ($data['password'] == $data['password_confirm']) {
                $passwordEncoder = $encoder->getEncoder($user);
                $password_encoded = $passwordEncoder->encodePassword($data['password'], '');
                $user->setPassword($password_encoded);
            }else{
                $this->addFlash("error", "Les mots de passe ne sont pas identique");
               // $this->redirectToRoute();
            }
            $em->persist($user);
            $em->flush();
            $this->redirectToRoute("pageutilisateur");
            $this->addFlash("success", "Utilisateur cree avec succes");
        }
        return $this->render("front/register.html.twig");
    }
}