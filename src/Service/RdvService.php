<?php

namespace App\Service;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class RdvService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function generateStudentsAndTeachers(){
        $namesE = ['James', 'Robert', 'John', 'Michael', 'William', 'David'];
        $namesP = ['Richard', 'Joseph', 'Thomas', 'Charles', 'Christopher', 'Daniel'];
        foreach ($namesE as $name){
            $etu = new Etudiant();
            $etu->setName($name);
            $etu->setEmail($name . '@generated');
            $this->entityManager->persist($etu);
        }
        $this->entityManager->flush();
        foreach ($namesP as $name){
            $pro = new Professeur();
            $pro->setName($name);
            $pro->setEmail($name . '@generated');
            $this->entityManager->persist($pro);
        }
        $this->entityManager->flush();
    }

}