<?php
namespace App\FormGenerator;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangeAccountPasswordFormGenerator extends BaseFormGenerator
{
    const OLD_PASSWORD_FIELD = 'old_password';
    const NEW_PASSWORD_FIELD = 'new_password';
    const SAVE_BUTTON = 'save';

    function generateForm($data = null): FormBuilderInterface
    {
        return $this->getFormFactory()->createNamedBuilder('')
            ->add(self::OLD_PASSWORD_FIELD, PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Your old password',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Old Password',
            ])
            ->add(self::NEW_PASSWORD_FIELD, RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => [
                    'attr' => [
                        'placeholder' => 'Your new password',
                        'class' => 'input-text full-width'
                    ],
                    'label' => 'New password',
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Confirm new password',
                        'class' => 'input-text full-width'
                    ],
                    'label' => 'Confirm new password',
                ],
            ])
            ->add(self::SAVE_BUTTON, SubmitType::class, ['attr' => [
                'class' => 'btn-large full-width'
            ]])
            ;

    }
}