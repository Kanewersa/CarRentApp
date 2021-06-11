<?php


namespace App\Controller;


use App\Entity\Car;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @Route("/reservation/{car}", name="reservation_form")
     */
    public function new(Car $car, Request $request): Response
    {
        $reservation = new Reservation();

        $form = $this->getForm($reservation);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Check if there are any other reservations within the same timeframe
            $reservations = $this->reservationRepository
                ->findByCarAndDates($car, $reservation->getPickupDate(),$reservation->getReturnDate());

            if (count($reservations) > 0) {
                // Refresh the page and display the error
                return $this->render('page/reservation.html.twig', [
                    'form' => $form->createView(),
                    'car' => $car,
                    'error' => "Wybrany termin jest zajęty.",
                ]);
            }

            // Create new reservation
            /** @var Reservation $reservation */
            $reservation = $form->getData();

            $reservation->setCar($car);
            $reservation->setUser($this->getUser());

            // Save the reservation
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('index', ['result' => 'success']);
        }

        return $this->render('page/reservation.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
            'error' => null,
        ]);
    }

    public function getForm($reservation): FormInterface
    {
        return $this->createFormBuilder($reservation)
            ->add('pickupDate', DateType::class, ['widget' => 'single_text'])
            ->add('returnDate', DateType::class, ['widget' => 'single_text'])
            ->add('save', SubmitType::class, ['label' => 'Zarezerwuj samochód'])
            ->getForm();
    }
}