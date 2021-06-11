<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirect('/login');
        }

        $cars = $this->getDoctrine()->getRepository(Car::class)->findAll();
        return $this->render('page/index.html.twig', [
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/reservations", name="user_reservations")
     */
    public function userReservations(): Response
    {
        if (!$this->getUser()) {
            return $this->redirect('/login');
        }

        return $this->render('page/user_reservations.html.twig', [
            'reservations' => $this->getUser()->getReservations()
        ]);
    }
}
