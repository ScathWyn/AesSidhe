<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminCharacterController extends Controller
{
    /**
     * @Route("/admin/characters", name="admin_characters", host="aesSidhe.fr")
     */
    public function index()
    {
		$characters=$this->getDoctrine()->getRepository(Character::class)->findAll();
        return $this->render('admin_characters/index.html.twig', [
            'characters' => $characters,
        ]);
    }
	
	/**
     * @Route("/admin/characters/show/{id}", name="admin_character_show", host="aesSidhe.fr")
     */
    public function show(Character $character)
    {
        return $this->render('admin_characters/show.html.twig', [
            'character' => $character,
        ]);
    }
	
	/**
     * @Route("/admin/characters/update/{id}", defaults={"id" = null}, name="admin_character_update", host="aesSidhe.fr")
     */
    public function update(Request $request, $id)
    {
		if(isset($id)) {
			//to update an existing Character
			$entityManager = $this->getDoctrine()->getManager();
			$character = $entityManager->getRepository(Character::class)->find($id);

			if (!$character) {
				throw $this->createNotFoundException(
					'No character found for id '.$id
				);
			}
		} else {
			//to create a new Character
			$character = new Character();
		}

        $characterForm = $this->createFormBuilder($character)
            ->add('firstName', TextType::class, array('label' => 'firstName'))		
			->add('lastName', TextType::class, array('label' => 'lastName'))
			->add('nickname', TextType::class, array('label' => 'nickname'))	
			->add('description', TextareaType::class, array('label' => 'description'))	
			->add('image', TextType::class, array('label' => 'image'))
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();	

		$characterForm->handleRequest($request);

		if ($characterForm->isSubmitted() && $characterForm->isValid()) {
			$character = $characterForm->getData();
			
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($character);
			$entityManager->flush();
			
			return $this->redirectToRoute('admin_characters');
		}			
			
        return $this->render('admin_characters/update.html.twig', [
			'characterForm' => $characterForm->createView(),
        ]);
    }
	
	/**
     * @Route("/admin/characters/delete/{id}", name="admin_character_delete", host="aesSidhe.fr")
     */
    public function delete(Character $character)
    {
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($character);
		$entityManager->flush();
			
		return $this->redirectToRoute('admin_characters');	
    }
	
}
