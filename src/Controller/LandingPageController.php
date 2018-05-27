<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LandingPageController extends Controller
{
    /**
     * @Route("/", name="landing_page", host="aesSidhe.fr")
     */
    public function index()
    {
        return $this->render('landing_page/index.html.twig', [
            'controller_name' => $_SERVER['MAILER_PASSWORD'],
        ]);
    }
}
