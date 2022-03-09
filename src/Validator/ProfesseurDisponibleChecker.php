<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

use App\Entity\Cours;

#[\Attribute]
class ProfesseurDisponibleChecker extends Constraint
{
    public $message = '{{ prenomProf }} {{ nomProf }} est déjà assigné à un cours pour cet horaire!';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}