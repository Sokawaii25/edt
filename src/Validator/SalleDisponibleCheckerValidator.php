<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Validator\SalleDisponibleChecker;
use Doctrine\ORM\EntityManagerInterface;

#[\Attribute]
class SalleDisponibleCheckerValidator extends ConstraintValidator
{   
    private $em;

    public $message = 'La salle {{ numSalle }} n\'est pas disponible à cette horaire!';

    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint){
        if (!$constraint instanceof SalleDisponibleChecker) {
            throw new UnexpectedTypeException($constraint, SalleDisponibleChecker::class);
        }

        $repo = $this->em->getRepository(Cours::class);
        
        $count = $repo->getCoursCountBySalleAndTime($value->getSalle()->getNumero(), $value->getDateHeureDebut(), $value->getDateHeureFin());

        if($count[1] != 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ numSalle }}', $value->getSalle()->getNumero())
                ->addViolation();
        }
    }

}