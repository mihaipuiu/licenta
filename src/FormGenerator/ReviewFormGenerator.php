<?php
namespace App\FormGenerator;

use App\Entity\HotelReview;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ReviewFormGenerator extends BaseFormGenerator
{
    const SERVICE_RATING_REVIEW_FIELD = 'service_rating';
    const SLEEP_RATING_REVIEW_FIELD = 'sleep_rating';
    const LOCATION_RATING_REVIEW_FIELD = 'location_rating';
    const POOL_RATING_REVIEW_FIELD = 'pool_rating';
    const VALUE_RATING_REVIEW_FIELD = 'value_rating';
    const CLEANLINESS_RATING_REVIEW_FIELD = 'cleanliness_rating';
    const ROOMS_RATING_REVIEW_FIELD = 'rooms_rating';
    const FITNESS_RATING_REVIEW_FIELD = 'fitness_rating';
    const OVERALL_RATING_REVIEW_FIELD = 'overall_rating';
    const TITLE_REVIEW_FIELD = 'title';
    const REVIEWER_NAME_FIELD = 'reviewer_name';
    const DESCRIPTION_REVIEW_FIELD = 'description';
    const SUBMIT_REVIEW_BUTTON = 'submit_review';
    const RATING_FIELD_ID = 'rating_field_id_';

    function generateForm(): FormBuilderInterface
    {
        return $this->getFormFactory()->createBuilder(
            FormType::class,
            new HotelReview(),
            ['attr' =>
                    ['class' => 'review-form']])
            ->add(self::SERVICE_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'0',
                    'value' => 0,
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::SLEEP_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'1',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::CLEANLINESS_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'2',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::LOCATION_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'3',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::ROOMS_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'4',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::VALUE_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'5',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::POOL_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'6',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::FITNESS_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'7',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::OVERALL_RATING_REVIEW_FIELD, NumberType::class, [
                'attr' => [
                    'class' => 'hidden '.self::RATING_FIELD_ID.'8',
                    'value' => 0
                ],
                'label' => false,
                'required' => false
            ])
            ->add(self::REVIEWER_NAME_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'your name',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your name',
            ])
            ->add(self::TITLE_REVIEW_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'enter a review title',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Title of your review'
            ])
            ->add(self::DESCRIPTION_REVIEW_FIELD, TextareaType::class, [
                'attr' => [
                    'placeholder' => 'enter your review (minimum 50 characters)',
                    'class' => 'input-text full-width',
                    'rows' => 5,
                    'minlength' => 50
                ],
                'label' => 'Your review'
            ])
            ->add(self::SUBMIT_REVIEW_BUTTON, SubmitType::class, ['attr' => [
                'class' => 'btn-large full-width'
            ]])
            ;
    }

}