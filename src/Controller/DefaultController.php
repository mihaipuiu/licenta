<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route(path="/", name="index")
     *
     * @return Response
     */
    public function homepage()
    {
        return $this->render('homepage/homepage.html.twig', [
            'subTitle' => 'Home'
        ]);
    }
}
