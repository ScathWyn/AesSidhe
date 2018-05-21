<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ConnectionController extends Controller
{
    /**
     * @Route("/connection", name="connection", host="aesSidhe.fr")
     */
    public function index(Request $request)
    {
		$user = new User();
        $user->setUsername('MyUsername');
		$user->setPlainPassword('PlainPassword');
		$user->setEmail('test@email.fr');

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
			->add('plainPassword', TextType::class)
			->add('email', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create User'))
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
			
        return $this->render('connection/index.html.twig', [
			'form' => $form->createView(),
        ]);
    }
}
