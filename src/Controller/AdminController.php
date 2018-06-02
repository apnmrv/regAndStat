<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CityController extends Controller
{
    /**
     * @Route("/city", name="city")
     */
    public function index()
    {
        return $this->render('city/index.html.twig', [
            'controller_name' => 'CityController',
        ]);
    }
}
