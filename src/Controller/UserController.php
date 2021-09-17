<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use App\Form\RdvType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="userindex")
     */
    public function index(): Response
    {
        return $this->showList();
    }

    /**
     * @Route("/list", name="userlist")
     */
    public function showList(): Response
    {
        $etudiants = $this->getDoctrine()->getManager()->getRepository(Etudiant::class)->findAll();
        $professeurs = $this->getDoctrine()->getManager()->getRepository(Professeur::class)->findAll();
        return $this->render('user/list.html.twig', [
            'etudiants' => $etudiants,
            'professeurs' => $professeurs,
        ]);
    }

    /**
     * @Route("/add", name="useradd")
     */
    public function addRdv(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('fonction', ChoiceType::class, [
                'label' => 'fonction',
                'choices'  => [
                    'etudiant' => "etudiant",
                    'professeur' => "professeur",
                ],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            switch ($form->get("fonction")->getData()){
                case "professeur" :
                    $prof = new Professeur();
                    $prof->setEmail($form->get("email")->getData());
                    $prof->setName($form->get("name")->getData());
                    $entityManager->persist($prof);
                    break;
                case "etudiant" :
                    $etudiant = new etudiant();
                    $etudiant->setEmail($form->get("email")->getData());
                    $etudiant->setName($form->get("name")->getData());
                    $entityManager->persist($etudiant);
                    break;
            }
            $entityManager->flush();
            return $this->showList();
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
