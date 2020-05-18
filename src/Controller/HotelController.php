<?php


namespace App\Controller;


use App\Entity\Hotel;
use App\Entity\HotelFacility;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route(path="hotels/{viewType}", name="hotels_list")
     *
     * @param string $viewType
     *
     * @return Response
     */
    public function list($viewType = 'block', HotelRepository $hotelRepository)
    {
        $hotels = $hotelRepository->findAll();
        return $this->render('hotels/view_types/'.$viewType.'_view.html.twig',  [
            'viewType' => $viewType,
            'subTitle' => 'Hotels List',
            'hotels' => $hotels
        ]);
    }

    /**
     * @Route(path="hotel/detailed/{id}", name="hotel_detailed")
     */
    public function detailed(Hotel $hotel, EntityManagerInterface $entityManager)
    {
        try {
            $hotel->getHotelFacility();
        } catch (\Exception $e) {
            $facility = new HotelFacility();
            $facility->setHotel($hotel);
            $facility->setHasFitness((bool)rand(0,1));
            $facility->setHasTv((bool)rand(0,1));
            $facility->setHasRestaurant((bool)rand(0,1));
            $facility->setHasWifi((bool)rand(0,1));
            $entityManager->persist($facility);
            $entityManager->flush();
            $hotel->setHotelFacility($facility);

        }
        return $this->render('hotels/hotel_detailed.html.twig', [
            'subTitle' => $hotel->getName(),
            'hotel' => $hotel
        ]);
    }
}