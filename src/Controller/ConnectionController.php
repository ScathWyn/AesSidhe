<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$user = $form->getData();
			
			$encoder = $this->container->get('security.password_encoder');
			$user->register($encoder);

			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
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
