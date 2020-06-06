<?php

namespace App\FormGenerator;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SignupFormGenerator extends BaseFormGenerator
{
    const FIRST_NAME_FIELD = 'first_name';
    const LAST_NAME_FIELD = 'last_name';
    const EMAIL_FIELD = 'email';
    const PASSWORD1_FIELD = 'password1';
    const PASSWORD2_FIELD = 'password2';
    const SIGNUP_BUTTON = 'signup';

    function generateForm($data = null): FormBuilderInterface
    {
        return $this->getFormFactory()->createBuilder(
            FormType::class,
            $data,
            ['attr' =>
                ['class' => 'signup-form']])
            ->add(self::FIRST_NAME_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'enter your first name',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your First Name'
            ])
            ->add(self::LAST_NAME_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'enter your last name',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your Last Name'
            ])
            ->add(self::EMAIL_FIELD, EmailType::class, [
                'attr' => [
                    'placeholder' => 'enter your email address',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your Email'
            ])
            ->add(self::PASSWORD1_FIELD, PasswordType::class, [
                'attr' => [
                    'placeholder' => 'enter password',
                    'class' => 'input-text full-width',
                ],
                'label' => 'Your Password'
            ])
            ->add(self::PASSWORD2_FIELD, PasswordType::class, [
                'attr' => [
                    'placeholder' => 'confirm password',
                    'class' => 'input-text full-width',
                ],
                'label' => 'Retype Password'
            ])
            ->add(self::SIGNUP_BUTTON, SubmitType::class, ['attr' => [
                'class' => 'btn-large full-width'
            ]]);
    }
}
