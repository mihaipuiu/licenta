<?php


namespace App\Controller;


use App\Entity\Hotel;
use App\Entity\HotelFacility;
use App\Entity\Room;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends BaseController
{
    /**
     * @Route(path="hotels/{viewType?list}", name="hotels_list")
     *
     * @param string $viewType
     * @param Request $request
     * @param HotelRepository $hotelRepository
     *
     * @return Response
     */
    public function list($viewType, Request $request, HotelRepository $hotelRepository)
    {
        $form = $this->getSearchForm()->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $requestURI = explode("?", $request->getUri())[1];
            $submittedForm = $form->getData();
            $hotels = $hotelRepository->findHotelsByFilters(
                $submittedForm[BaseController::NAME_FORM_FIELD],
                $submittedForm[BaseController::MIN_PRICE_FORM_FIELD],
                $submittedForm[BaseController::MAX_PRICE_FORM_FIELD],
                $submittedForm[BaseController::MIN_OVERALL_RATING_FORM_FIELD],
                $submittedForm[BaseController::GUESTS_NUMBER_FORM_FIELD]
            );
            $checkInDate = \DateTime::createFromFormat('m/d/Y', $submittedForm[BaseController::DATE_FROM_FORM_FIELD]);
            $checkOutDate = \DateTime::createFromFormat('m/d/Y', $submittedForm[BaseController::DATE_TO_FORM_FIELD]);
        } else {
            $requestURI = '';
            $checkInDate = null;
            $checkOutDate = null;
            $hotels = $hotelRepository->findHotelsByFilters();
        }

        $hotels = $this->filterHotelsByCheckDate($hotels, $checkInDate, $checkOutDate);

        return $this->render('hotels/view_types/'.$viewType.'_view.html.twig',  [
            'viewType' => $viewType,
            'subTitle' => 'Hotels List',
            'hotels' => $hotels,
            'lowestPriceRoom' => Hotel::getLowestPriceRoomOfHotels($hotels),
            'highestPriceRoom' => Hotel::getHighestPriceRoomOfHotels($hotels),
            'searchForm' => $this->getSearchForm()->createView(),
            'requestURI' => $requestURI
        ]);
    }

    /**
     * @Route(path="hotel/detailed/{id}", name="hotel_detailed", requirements={"id"="\d+"})
     *
     * @param Hotel $hotel
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
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
            'hotel' => $hotel,
            'searchForm' => $this->getSearchForm()->createView()
        ]);
    }

    private function filterHotelsByCheckDate($hotels, \DateTime $checkInDate = null, \DateTime $checkOutDate = null)
    {
        $filteredHotels = [];
        if($checkInDate && $checkOutDate) {
            /** @var Hotel $hotel */
            foreach($hotels as $hotel) {
                if($hotel->hasAnyRoomAvailable($checkInDate, $checkOutDate)) {
                    $filteredHotels[] = $hotel;
                }
            }
            return $filteredHotels;
        }
        return $hotels;
    }
}