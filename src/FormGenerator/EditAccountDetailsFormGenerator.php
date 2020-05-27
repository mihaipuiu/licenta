<?php
namespace App\FormGenerator;

use App\Entity\User;
use App\Exception\InvalidDataClassException;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditAccountDetailsFormGenerator extends BaseFormGenerator
{
    const EMAIL_FIELD = 'email';
    const FIRST_NAME_FIELD = 'first_name';
    const LAST_NAME_FIELD = 'last_name';
    const SAVE_BUTTON = 'save';

    function generateForm($data = null): FormBuilderInterface
    {
        /** User $data */
        if(!($data instanceof User)) {
            throw new InvalidDataClassException();
        }

        return $this->getFormFactory()->createBuilder(
            FormType::class,
            $data,
            ['attr' =>
                ['class' => 'contact-form']])
            ->add(self::FIRST_NAME_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'your first name',
                    'class' => 'input-text full-width'
                ],
                'label' => 'First Name',
                'empty_data' => $data->getFirstName(),
            ])
            ->add(self::LAST_NAME_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'your last name',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Last Name',
                'empty_data' => $data->getLastName(),
            ])
            ->add(self::EMAIL_FIELD, EmailType::class, [
                'attr' => [
                    'placeholder' => 'enter your email address',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Email',
                'empty_data' => $data->getEmail(),

            ])
            ->add(self::SAVE_BUTTON, SubmitType::class, ['attr' => [
                'class' => 'btn-large full-width'
            ]])
            ;
    }
}