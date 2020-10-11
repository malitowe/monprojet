<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security as SecurityContext;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Util\TokenGenerator;
use App\Entity\Administrator;

class SecurityController extends AbstractController {

    /**
     * @Route("/admin/login", name="adminlogin")
     */
    public function adminLoginAction(Request $request, AuthenticationUtils $authenticationUtils) {
        // get the login error if there is one
        $error = null;
        $error = $authenticationUtils->getLastAuthenticationError();
        if (!is_null($error)) {
            $this->addFlash(
                'error', $error->getMessageKey()
            );
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('admin/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
    * @Route("/admin/register", name="adminregister")
    */
    public function adminRegisterAction(Request $request, , EncoderFactoryInterface $encoder){
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == "POST"){
            $tokenGenerator = new TokenGenerator();
            $data = $request->request->get("user");
            $user = new Administrator();
            $user->setCreatedAt(new \DateTime());
            $user->setFullName($data['username']);
            $user->setUsername($data['username']);
            $user->setConfirmationToken($tokenGenerator->generateToken());
            $user->setEmail($data['email']);
            $user->setUpdatedAt(new \DateTime());
            $em->persist($user);


            if ($data['password'] == $data['password_confirm']) {
                $passwordEncoder = $encoder->getEncoder($user);
                $password_encoded = $passwordEncoder->encodePassword($data['password'], '');
                $user->setPassword($password_encoded);
            }else{
                $this->addFlash("error", "Les mots de passe ne sont pas identique");
            }
            $em->persist($user);
            $em->flush();
            $this->redirectToRoute("admin");
            $this->addFlash("success", "Utilisateur cree avec succes");
        }
        return $this->render("front/register.html.twig");
    }

    /**
     * @Method({"POST"})
     * @Route("/admin/admin_check", name="admin_check")
     */
    public function checkAdmin()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
	* @Method({"GET"})
	* @Route("/admin/logout", name="adminlogout")
	*/
	public function adminLogout()
	{
		throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
	}

}

