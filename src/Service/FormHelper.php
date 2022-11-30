<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;

class FormHelper
{
    public function getErrors(FormInterface $form): array|string
    {
        foreach ($form->getErrors() as $error) {
            return $error->getMessage();
        }

        $errors = array();
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childError = $this->get($childForm)) {
                    $errors[$childForm->getName()] = $childError;
                }
            }
        }

        return $errors;
    }
}