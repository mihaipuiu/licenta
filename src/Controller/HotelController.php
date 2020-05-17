<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route(path="hotels/{viewType}", name="hotels_list")
     */
    public function list($viewType = 'list')
    {
        return $this->render('hotels/view_types/'.$viewType.'_view.html.twig',  [
            'viewType' => $viewType,
            'subTitle' => 'Hotels List',
            'hotels' => []
        ]);
    }

    /**
     * @Route(path="hotel/detailed", name="hotel_detailed")
     */
    public function detailed()
    {
        return $this->render('hotels/hotel_detailed.html.twig', [
            'subTitle' => 'Hotel Detailed'
        ]);
    }
}