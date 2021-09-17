<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use App\Form\RdvType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('rdv/index.html.twig', [
        ]);
    }

}
