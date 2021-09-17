<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use App\Entity\User;
use App\Form\RdvType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{

    /**
     * @Route("/add", name="add_account")
     */
    public function addAccount(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $acc = new User();
        $form = $this->createForm(UserType::class, $acc);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $acc->setPassword($passwordHasher->hashPassword(
                $acc,
                $form->get('password')->getData()
            ));
            $acc->setEmail($form->get("email")->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($acc);
            $entityManager->flush();
            $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
            return $this->render('account/list.html.twig', [
                'users' => $users,
            ]);

        }
        return $this->render('account/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list", name="list_account")
     */
    public function listAccount(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('account/list.html.twig', [
            'users' => $users,
        ]);

    }

}
