<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Repository\CoursRepository;
use App\Entity\Cours;
use App\Validator\ProfesseurDisponibleChecker;
use Doctrine\ORM\EntityManagerInterface;

#[\Attribute]
class ProfesseurDisponibleCheckerValidator extends ConstraintValidator
{   
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint){
        if (!$constraint instanceof ProfesseurDisponibleChecker) {
            throw new UnexpectedTypeException($constraint, ProfesseurDisponibleChecker::class);
        }

        $repo = $this->em->getRepository(Cours::class);
        
        $count = $repo->getCoursCountByProfesseurAndTime($value->getProfesseur()->getId(), $value->getDateHeureDebut(), $value->getDateHeureFin());

        if($count[1] != 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ prenomProf }}', $value->getProfesseur()->getPrenom())
                ->setParameter('{{ nomProf }}', $value->getProfesseur()->getNom())
                ->addViolation();
        }
    }

}