<?php
namespace App\Controller;

use App\Entity\Hotel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{
    /**
     * @Route(path="/", name="index")
     *
     * @return Response
     */
    public function homepage()
    {
        return $this->render('homepage/homepage.html.twig', [
            'subTitle' => 'Home',
            'searchForm' => $this->getSearchForm()->createView(),
            'user' => $this->getUser()
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
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }
}
