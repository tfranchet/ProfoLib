<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use App\Entity\User;
use App\Form\RdvType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            $role = $form->get("roles")->getData();
            if(in_array('ROLE_ETUDIANT', $role)){
                $etudiant = new Etudiant();
                $etudiant->setEmail($form->get("email")->getData());
                $etudiant->setUser($acc);
                $etudiant->setName($form->get("email")->getData());
                $entityManager->persist($etudiant);
            }
            else if(in_array('ROLE_PROFESSEUR', $role)){
                $etudiant = new Professeur();
                $etudiant->setEmail($form->get("email")->getData());
                $etudiant->setUser($acc);
                $etudiant->setName($form->get("email")->getData());
                $entityManager->persist($etudiant);
            }
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
