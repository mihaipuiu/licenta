<?php
namespace App\FormGenerator;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;

abstract class BaseFormGenerator
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    protected function getFormFactory(): FormFactoryInterface
    {
        return $this->formFactory;
    }

    abstract function generateForm($data = null): FormBuilderInterface;
}