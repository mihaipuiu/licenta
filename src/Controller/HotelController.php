<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\HotelFacility;
use App\Entity\HotelReview;
use App\Entity\Room;
use App\Entity\RoomOccupation;
use App\Exception\InvalidDataClassException;
use App\FormGenerator\HotelSearchFormGenerator;
use App\FormGenerator\ReviewFormGenerator;
use App\FormGenerator\SearchAvailableRoomsFormGenerator;
use App\Repository\HotelRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $requestURIWithoutSortNorOrder = $request->query->all();
        unset($requestURIWithoutSortNorOrder['sort']);
        unset($requestURIWithoutSortNorOrder['order']);
        $requestURIWithoutSortNorOrder = $this->implodeRequestURI($requestURIWithoutSortNorOrder);

        $hotels = $hotelRepository->findHotelsByFilters(
            $request->query->all()[HotelSearchFormGenerator::NAME_FORM_FIELD] ?? '',
            $request->query->all()[HotelSearchFormGenerator::MIN_PRICE_FORM_FIELD] ?? 0,
            $request->query->all()[HotelSearchFormGenerator::MAX_PRICE_FORM_FIELD] ?? 88888,
            $request->query->all()[HotelSearchFormGenerator::MIN_OVERALL_RATING_FORM_FIELD] ?? 0.0,
            $request->query->all()[HotelSearchFormGenerator::GUESTS_NUMBER_FORM_FIELD] ?? 0,
            $request->query->all()['sort'] ?? 'name',
            $request->query->all()['order'] ?? 'asc'
        );

        $checkInDate = !empty($request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD]) ? DateTime::createFromFormat('m/d/Y', $request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD]) : null;
        $checkOutDate = !empty($request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD]) ? DateTime::createFromFormat('m/d/Y', $request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD]) : null;

        $hotels = $this->filterHotelsByCheckDate($hotels, $checkInDate, $checkOutDate);

        $requestURI = $this->implodeRequestURI($request->query->all());

        return $this->render('hotels/view_types/'.$viewType.'_view.html.twig',  [
            'viewType' => $viewType,
            'subTitle' => 'Hotels List',
            'hotels' => $hotels,
            'lowestPriceRoom' => Hotel::getLowestPriceRoomOfHotels($hotels),
            'highestPriceRoom' => Hotel::getHighestPriceRoomOfHotels($hotels),
            'searchForm' => $this->getSearchForm()->createView(),
            'requestURI' => $requestURI,
            'requestURIWithoutSortNorOrder' => $requestURIWithoutSortNorOrder,
            'minOverallRating' => $request->query->all()[HotelSearchFormGenerator::MIN_OVERALL_RATING_FORM_FIELD] ?? 0.0,
            'sort' => $request->query->all()['sort'] ?? 'name',
            'order' => $request->query->all()['order'] ?? 'asc',
            'user' => $this->getUser(),
            'checkin' => $request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD] ?? null,
            'checkout' =>$request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD] ?? null
        ]);
    }

    /**
     * @Route(path="hotel/detailed/{id}", name="hotel_detailed", requirements={"id"="\d+"})
     *
     * @param Hotel $hotel
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ReviewFormGenerator $reviewFormGenerator
     *
     * @param SearchAvailableRoomsFormGenerator $availableRoomsFormGenerator
     * @return Response
     * @throws InvalidDataClassException
     */
    public function detailed(Hotel $hotel, Request $request, EntityManagerInterface $entityManager, ReviewFormGenerator $reviewFormGenerator, SearchAvailableRoomsFormGenerator $availableRoomsFormGenerator)
    {
        $hotel->incrementViews();
        $entityManager->persist($hotel);

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
            $hotel->setHotelFacility($facility);
        }

        $reviewForm = $reviewFormGenerator->generateForm(new HotelReview())
            ->setAction($this->generateUrl('hotel_detailed', ['id' => $hotel->getId()]))
            ->setMethod(Request::METHOD_POST)
            ->getForm();

        $roomSearchForm = $availableRoomsFormGenerator->generateForm(null)
            ->setAction($this->generateUrl('hotel_detailed', ['id' => $hotel->getId(), '_fragment' => 'hotel-availability']))
            ->setMethod(Request::METHOD_GET)
            ->getForm();

        if($request->getMethod() == Request::METHOD_POST) {
            $reviewForm->handleRequest($request);

            if($reviewForm->isSubmitted() && $reviewForm->isValid()) {
                /** @var HotelReview $hotelReview */
                $hotelReview = $reviewForm->getData();
                $hotelReview->setHotel($hotel);

                $entityManager->persist($hotelReview);
            }
        }

        if($request->getMethod() == Request::METHOD_GET) {
            $roomSearchForm->handleRequest($request);
            if($roomSearchForm->isSubmitted() && $roomSearchForm->isValid()) {
                $minGuests = $request->query->all()[SearchAvailableRoomsFormGenerator::FORM_NAME][SearchAvailableRoomsFormGenerator::GUESTS_NUMBER_FORM_FIELD] ?? 1;
                $checkIn = $request->query->all()[SearchAvailableRoomsFormGenerator::FORM_NAME][SearchAvailableRoomsFormGenerator::DATE_FROM_FORM_FIELD] ?? null;
                $checkOut = $request->query->all()[SearchAvailableRoomsFormGenerator::FORM_NAME][SearchAvailableRoomsFormGenerator::DATE_TO_FORM_FIELD] ?? null;
            }
        }

        $checkIn = $checkIn ?? $request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD] ?? null;
        $checkOut = $checkOut ?? $request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD] ?? null;
        $minGuests = $minGuests ?? 1;

        $availableRooms = $hotel->getAvailableRooms($checkIn, $checkOut, $minGuests);

        $entityManager->flush();

        return $this->render('hotels/hotel_detailed.html.twig', [
            'subTitle' => $hotel->getName(),
            'hotel' => $hotel,
            'rooms' => $availableRooms,
            'searchForm' => $this->getSearchForm()->createView(),
            'reviewForm' => $reviewForm->createView(),
            'roomSearchForm' => $roomSearchForm->createView(),
            'user' => $this->getUser(),
            'checkin' => $checkIn,
            'checkout' => $checkOut
        ]);
    }

    /**
     * @Route(path="hotel/book-a-room/{id}", name="book_a_room", requirements={"id"="\d+"})
     *
     * @param Room $room
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function bookRoomDetails(Room $room, Request $request, EntityManagerInterface $entityManager)
    {
        if(!empty($request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD])) {
            $checkIn = DateTime::createFromFormat('m/d/Y', $request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD]) ?: null;
        } else {
            $checkIn = null;
        }

        if(!empty($request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD])) {
            $checkOut = DateTime::createFromFormat('m/d/Y', $request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD]) ?: null;
        } else {
            $checkOut = null;
        }

        $formattedCheckIn = !empty($checkIn) ? $checkIn->format('m/d/Y') : null;
        $formattedCheckOut = !empty($checkOut) ? $checkOut->format('m/d/Y') : null;

        return $this->render('hotels/room-booking.html.twig', [
            'subTitle' => 'Room Booking',
            'user' => $this->getUser(),
            'searchForm' => $this->getSearchForm()->createView(),
            'room' => $room,
            'realCheckOut' => $this->getRealCheckoutDate($checkOut),
            'roomIsAvailable' => $room->roomIsAvailable($checkIn, $checkOut),
            'occupationDayCount' => $this->getOccupationDayCount($checkIn, $checkOut),
            'checkIn' => $formattedCheckIn,
            'checkOut' => $formattedCheckOut
        ]);
    }

    /**
     * @Route(path="hotel/confirm-book-a-room/{id}", name="confirm_book_a_room", requirements={"id"="\d+"})
     *
     * @param Room $room
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function confirmBooking(Room $room, Request $request, EntityManagerInterface $entityManager)
    {
        if(!empty($request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD])) {
            $checkIn = DateTime::createFromFormat('m/d/Y', $request->query->all()[HotelSearchFormGenerator::DATE_TO_FORM_FIELD]) ?: null;
        } else {
            $checkIn = null;
        }

        if(!empty($request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD])) {
            $checkOut = DateTime::createFromFormat('m/d/Y', $request->query->all()[HotelSearchFormGenerator::DATE_FROM_FORM_FIELD]) ?: null;
        } else {
            $checkOut = null;
        }

        if(empty($checkIn) || empty($checkOut) || !$room->roomIsAvailable($checkIn, $checkOut) || !$this->getUser()) {
            return $this->redirect($request->headers->get('referer'));
        }

        $roomOccupation = new RoomOccupation();
        $roomOccupation->setRoom($room);
        $roomOccupation->setStartDate($checkIn);
        $roomOccupation->setEndDate($checkOut);
        $roomOccupation->setUser($this->getUser());

        $entityManager->persist($roomOccupation);
        $entityManager->flush();

        return $this->redirectToRoute('booking-confirmed', ['id' => $roomOccupation->getId()]);
    }

    /**
     * @Route(path="hotel/booking-confirmed/{id}", name="booking-confirmed", requirements={"id"="\d+"})
     *
     * @param RoomOccupation $roomOccupation
     */
    public function bookingConfirmed(RoomOccupation $roomOccupation)
    {
        return $this->render('hotels/booking-confirmed.html.twig', [
            'subTitle' => 'Booking Confirmed',
            'user' => $this->getUser(),
            'searchForm' => $this->getSearchForm()->createView(),
            'roomOccupation' => $roomOccupation,
            'occupationDayCount' => $this->getOccupationDayCount($roomOccupation->getStartDate(), $roomOccupation->getEndDate()),
            'realCheckOut' => $this->getRealCheckoutDate($roomOccupation->getEndDate()),
        ]);
    }

    private function filterHotelsByCheckDate($hotels, DateTime $checkInDate = null, DateTime $checkOutDate = null)
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

    private function implodeRequestURI($requestURI)
    {
        return implode('&', array_map(
            function ($v, $k) {
                if(is_array($v)){
                    return $k.'[]='.implode('&'.$k.'[]=', $v);
                }else{
                    return $k.'='.$v;
                }
            },
            $requestURI,
            array_keys($requestURI)
        ));
    }

    /**
     * @param DateTime|null $checkIn
     * @param DateTime|null $checkOut
     *
     * @return int
     */
    private function getOccupationDayCount(DateTime $checkIn = null, DateTime $checkOut = null)
    {
        if(!empty($checkIn) && !empty($checkOut)) {
            return (int)$checkIn->diff($checkOut)->format('%a') + 1;
        }
            return 0;
    }

    private function getRealCheckoutDate(DateTime $checkOut = null)
    {
        if(!empty($checkOut)) {
            return $checkOut->add(new \DateInterval('P1D'))->format('m/d/Y');
        }
        return null;
    }
}