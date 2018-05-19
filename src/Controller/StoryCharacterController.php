<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\StoryCharacter;

class StoryCharacterController extends Controller
{
    /**
     * @Route("/storyCharacter", name="story_character", host="aesSidhe.fr")
     */
    public function index()
    {
		$storyCharacters=$this->getDoctrine()->getRepository(StoryCharacter::class)->findAll();
		
        return $this->render('story_character/index.html.twig', [
            'storyCharacters' => $storyCharacters,
        ]);
    }
}
