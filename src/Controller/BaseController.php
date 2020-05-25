<?php


namespace App\Controller;


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
    private ?FormInterface $searchForm;

    const NAME_FORM_FIELD = 'name';
    const DATE_FROM_FORM_FIELD = 'date_from';
    const DATE_TO_FORM_FIELD = 'date_to';
    const GUESTS_NUMBER_FORM_FIELD = 'guests_number';
    const MIN_OVERALL_RATING_FORM_FIELD = 'min_overall_rating';
    const MIN_PRICE_FORM_FIELD = 'min_price';
    const MAX_PRICE_FORM_FIELD = 'max_price';

    protected function getFormFactory($data = null, array $options = []): FormFactoryInterface
    {
        return $this->container->get('form.factory');
    }

    public function getSearchForm(): FormInterface
    {
        if(empty($this->searchForm)) {
            $this->searchForm = $this->getFormFactory()->createNamedBuilder('')
                ->add(self::NAME_FORM_FIELD, TextType::class, [
                    'attr' => [
                        'placeholder' => 'Where do you want to go?',
                        'class' => 'input-text white-bg full-width where'
                    ],
                    'label' => false,
                    'required' => false
                ])
                ->add(self::DATE_FROM_FORM_FIELD, TextType::class, [
                    'attr' => [
                        'class' => 'input-text white-bg full-width check-in',
                        'placeholder' => 'Check In',
                        'name' => 'date_from'
                    ],
                    'label' => false,
                    'required' => false
                ])
                ->add(self::DATE_TO_FORM_FIELD, TextType::class, [
                    'attr' => [
                        'class' => 'input-text white-bg full-width check-out',
                        'placeholder' => 'Check Out'
                    ],
                    'label' => false,
                    'required' => false
                ])
                ->add(self::MIN_OVERALL_RATING_FORM_FIELD, TextType::class, [
                    'attr' => [
                        'class' => 'hidden',
                        'value' => 0.0
                    ],
                    'label' => false
                ])
                ->add(self::MIN_PRICE_FORM_FIELD, NumberType::class, [
                    'attr' => [
                        'class' => 'hidden',
                        'value' => 0
                    ],
                    'label' => false
                ])
                ->add(self::MAX_PRICE_FORM_FIELD, NumberType::class, [
                    'attr' => [
                        'class' => 'hidden',
                        'value' => 99999
                    ],
                    'label' => false
                ])
                ->add(self::GUESTS_NUMBER_FORM_FIELD, ChoiceType::class, [
                    'choices' => [
                        '1 Guest' => 1,
                        '2 Guests' => 2,
                        '3 Guests' => 3,
                        '4 Guests' => 4,
                        '5 Guests' => 5,
                    ],
                    'attr' => [
                        'class' => 'full-width white-bg'
                    ],
                    'label' => false
                ])
                ->add('searchButton', SubmitType::class, ['attr' => [
                    'class' => 'btn-medium uppercase full-width'
                ]])
                ->setAction($this->generateUrl('hotels_list'))
                ->setMethod(Request::METHOD_GET)
                ->getForm();
        }

        return $this->searchForm;
    }
}