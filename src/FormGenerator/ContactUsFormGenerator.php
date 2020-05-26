<?php
namespace App\FormGenerator;

use App\Entity\ContactMessage;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactUsFormGenerator extends BaseFormGenerator
{
    const EMAIL_FIELD = 'email';
    const NAME_FIELD = 'name';
    const MESSAGE_FIELD = 'description';
    const SEND_MESSAGE_BUTTON = 'send_message';

    function generateForm(): FormBuilderInterface
    {
        return $this->getFormFactory()->createBuilder(
            FormType::class,
            new ContactMessage(),
            ['attr' =>
                ['class' => 'contact-form']])
            ->add(self::NAME_FIELD, TextType::class, [
                'attr' => [
                    'placeholder' => 'your name',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your name',
            ])
            ->add(self::EMAIL_FIELD, EmailType::class, [
                'attr' => [
                    'placeholder' => 'enter your email address',
                    'class' => 'input-text full-width'
                ],
                'label' => 'Your Email'
            ])
            ->add(self::MESSAGE_FIELD, TextareaType::class, [
                'attr' => [
                    'placeholder' => 'write your message here',
                    'class' => 'input-text full-width',
                    'rows' => 6,
                    'minlength' => 10
                ],
                'label' => 'Your message'
            ])
            ->add(self::SEND_MESSAGE_BUTTON, SubmitType::class, ['attr' => [
                'class' => 'btn-large full-width'
            ]])
            ;
    }
}