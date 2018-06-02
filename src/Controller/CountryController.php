<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Country;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    /**
     * @Route("/country", name="country")
     */
    public function index()
    {
        return $this->render('country/index.html.twig ', [
            'controller_name' => 'CountryController',
        ]);
    }

    /**
     * @Route("/country/{id}", name="country_show")
     */
    public function show($id)
    {
        $country = $this->getDoctrine()
            ->getRepository(Country::class)
            ->find($id);

        if (!$country) {
            throw $this->createNotFoundException(
                'No country found for id '.$id
            );
        }

        return new Response('Check out this great country: '.$country->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
