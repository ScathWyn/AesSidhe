<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailerService;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//to check and delete
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

        $signInForm = $this->createFormBuilder(['_username' => $lastUsername])
            ->add('_username', TextType::class, array('label' => 'Login'))		
			->add('_password', PasswordType::class, array('label' => 'Mot de passe'))
			->add('_remember_me', CheckboxType::class, array('label' => 'Se souvenir', 'required' => false))
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();
		
		return $this->render('security/sign_in/index.html.twig', [
			'signInForm' => $signInForm->createView(),
			'error' => $error,
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
    public function register(Request $request, MailerService $mailerService)
    {
		$user = new User();

        $registerForm = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('label' => 'Login'))		
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class,
				'invalid_message' => 'Les deux champs du mot de passe doivent être identiques.',
				'options' => array('attr' => array('class' => 'password-field')),
				'first_options'  => array('label' => 'Mot de passe'),
				'second_options' => array('label' => 'Confirmation du mot de passe'),
				))
			->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();	


		$registerForm->handleRequest($request);

		if ($registerForm->isSubmitted() && $registerForm->isValid()) {
			$user = $registerForm->getData();
			
			/* Hashing the password */
		    $encoder = $this->container->get('security.password_encoder');
			$password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
			
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();
			
			$mailerService->createEmailAndSendTo('accountCreation', $user);

			return $this->redirectToRoute('landing_page');
		}			
			
        return $this->render('security/register/index.html.twig', [
			'registerForm' => $registerForm->createView(),
        ]);
    }
	
	/**
     * @Route("/mail", name="mail", host="aesSidhe.fr")
     */
	// public function sendEmail(MailerService $mailerService)
	// {
		// $user = new User();
		// $user->setUsername('Toto');
		// $user->setEmail('test@gmail.com');

		// $mailerService->createEmailAndSendTo('accountCreation', $user);
		// return $this->redirectToRoute('landing_page');
	// }
	
}
