<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Character;

class CharacterController extends Controller
{
    /**
     * @Route("/character", name="character", host="aesSidhe.fr")
     */
    public function index()
    {
		$characters=$this->getDoctrine()->getRepository(Character::class)->findAll();
		
        return $this->render('character/index.html.twig', [
            'characters' => $characters,
        ]);
    }
}
