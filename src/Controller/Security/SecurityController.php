<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security as SecurityContext;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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

