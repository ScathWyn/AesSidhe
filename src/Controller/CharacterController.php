<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
