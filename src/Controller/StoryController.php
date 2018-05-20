<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StoryController extends Controller
{
    /**
     * @Route("/story", name="story", host="aesSidhe.fr")
     */
    public function index()
    {
        return $this->render('story/index.html.twig', [
            'controller_name' => 'StoryController',
        ]);
    }
}
