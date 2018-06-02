<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\RequestDataHandler;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/enroll", name="enroll")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $encoder)
    {
        // Creating a request object to keep all the form data
        // and giving'im tools to process it

        $requestDataHandler = new RequestDataHandler(
            $this->getDoctrine()->getManager(),
            $encoder);

        // Creating a form object and giving'im request object to store the input data

        $form = $this->createForm(
            RegistrationFormType::class, $requestDataHandler );

        // get POST data from client

        $form->handleRequest($request);

        // Check if it valid

        if ($form->isSubmitted() && $form->isValid()) {

            // Let datahandler do its job

            $requestDataHandler->processData();


            // Sending new user to the login form

            return $this->redirectToRoute('login');
        }

        // Sending user back as the data is not valid or exist

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
