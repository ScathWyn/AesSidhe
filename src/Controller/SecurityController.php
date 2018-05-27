<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SecurityController extends Controller
{
    /**
     * @Route("/signIn", name="sign_in", host="aesSidhe.fr")
     */
    public function signIn(Request $request, AuthenticationUtils $authenticationUtils)
    {
		
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
        return $this->render('security/sign_in/index.html.twig', [
            'last_username' => $lastUsername,
			'error'         => $error,
        ]);
    }
	
	/**
     * @Route("/signOut", name="sign_out", host="aesSidhe.fr")
     */
    public function signOut()
    {
		 return $this->redirectToRoute('landing_page');
	}
	
	/**
     * @Route("/register", name="register", host="aesSidhe.fr")
     */
    public function register(Request $request)
    {
		$user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('label' => 'Login'))		
			->add('plainPassword', TextType::class, array('label' => 'Mot de passe'))
			->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();	


		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user = $form->getData();
			
			/* Hashing the password */
		    $encoder = $this->container->get('security.password_encoder');
			$password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
			
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('landing_page');
		}			
			
        return $this->render('security/register/index.html.twig', [
			'form' => $form->createView(),
        ]);
    }
}
