<?php


namespace App\Controller;


use App\FormGenerator\HotelSearchFormGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{
    protected ?FormInterface $searchForm;
    private HotelSearchFormGenerator $hotelSearchFormGenerator;

    public function __construct(HotelSearchFormGenerator $hotelSearchFormGenerator)
    {
        $this->hotelSearchFormGenerator = $hotelSearchFormGenerator;
    }

    public function getSearchForm(): FormInterface
    {
        if(empty($this->searchForm)) {
            $this->searchForm = $this->hotelSearchFormGenerator
                ->generateForm()
                ->setAction($this->generateUrl('hotels_list'))
                ->setMethod(Request::METHOD_GET)
                ->getForm();
        }
        return $this->searchForm;
    }
}