<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

use App\Entity\Cours;

#[\Attribute]
class SalleDisponibleChecker extends Constraint
{
    public $message = 'La salle {{ numSalle }} n\'est pas disponible à cet horaire!';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}