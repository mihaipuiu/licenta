<?php
namespace App\FormGenerator;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchAvailableRoomsFormGenerator extends BaseFormGenerator
{
    const FORM_NAME = 'available-rooms';
    const DATE_FROM_FORM_FIELD = 'date_from';
    const DATE_TO_FORM_FIELD = 'date_to';
    const GUESTS_NUMBER_FORM_FIELD = 'guests_number';
    const SEARCH_BUTTON_NAME = 'search_now';

    function generateForm($data = null): FormBuilderInterface
    {
        return $this->getFormFactory()->createNamedBuilder(self::FORM_NAME)
            ->add(self::DATE_FROM_FORM_FIELD, TextType::class, [
                'attr' => [
                    'class' => 'input-text full-width',
                    'placeholder' => 'Check In mm/dd/yy',
                    'name' => 'date_from'
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::DATE_TO_FORM_FIELD, TextType::class, [
                'attr' => [
                    'class' => 'input-text full-width',
                    'placeholder' => 'Check Out mm/dd/yy'
                ],
                'label' => false,
                'required' => false
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
                    'class' => 'full-width'
                ],
                'label' => false
            ])
            ->add(self::SEARCH_BUTTON_NAME, SubmitType::class, ['attr' => [
                'data-animation-duration' => 1,
                'data-animation-type' => 'bounce',
                'class' => 'full-width icon-check animated'
            ]]);

    }
}