<?php
namespace App\FormGenerator;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormGenerator extends BaseFormGenerator
{
    const EMAIL_FIELD = 'email';
    const PASSWORD_FIELD = 'password';
    const LOGIN_BUTTON = 'login';

    function generateForm($data = null): FormBuilderInterface
    {
        return $this->getFormFactory()->createBuilder(
            FormType::class,
            $data,
            ['attr' =>
                ['class' => 'login-form']])
            ->add(self::EMAIL_FIELD, EmailType::class, [
                'attr' => [
                    'placeholder' => 'enter your email address',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your Email'
            ])
            ->add(self::PASSWORD_FIELD, PasswordType::class, [
                'attr' => [
                    'placeholder' => 'enter password',
                    'class' => 'input-text full-width',
                ],
                'label' => 'Your Password'
            ])
            ->add(self::LOGIN_BUTTON, SubmitType::class, ['attr' => [
                'class' => 'btn-large full-width'
            ]])
            ;
    }
}