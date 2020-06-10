<?php
namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{
    /**
     * @Route(path="/", name="index")
     *
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function homepage(HotelRepository $hotelRepository)
    {
        return $this->render('homepage/homepage.html.twig', [
            'subTitle' => 'Home',
            'searchForm' => $this->getSearchForm()->createView(),
            'user' => $this->getUser(),
            'highestRated' => $hotelRepository->highestRatedHotels(4),
            'mostViewed' => $hotelRepository->mostViewedHotels(4)
        ]);
    }

    /**
     * @Route(path="slideshow/popup/{id}", name="slideshow_popup")
     * @param Hotel $hotel
     * @return Response
     */
    public function slideshowPopup(Hotel $hotel)
    {
        $photos = $hotel->getHotelPhotos();
        return $this->render('slideshow/slideshow-popup.html.twig', ['photos' => $photos]);
    }

    /**
     * @Route(path="store/referer", name="store_referer")
     * @param Request $request
     */
    public function storeReferer(Request $request)
    {
        $q = $request->query->all();
        if (!empty($q['referer'])) {
            $this->get('session')->set('referer', $q['referer']);
        }

        return new Response();
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }
}
