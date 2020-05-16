<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/{slug}")
     */
    public function homepage($slug)
    {
        return $this->render('default/homepage.html.twig', [
            'slug' => ucwords(str_replace('-', ' ', $slug))
        ]);
    }
}