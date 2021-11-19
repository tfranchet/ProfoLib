<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use App\Form\RdvType;
use App\Repository\ProfesseurRepository;
use App\Repository\RdvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/rdv")
 */
class RdvController extends AbstractController
{

    /**
     * @Route("/", name="rdvindex")
     */
    public function index(): Response
    {
        return $this->showList();
    }

    /**
     * @Route("/list/{id}", name="rdvlist")
     */
    public function showList(Professeur $id = null): Response
    {
        if($id != null){
            $rdvs = $this->getDoctrine()->getManager()->getRepository(Rdv::class)->findByProfesseur($id);
        } else {
            $rdvs = $this->getDoctrine()->getManager()->getRepository(Rdv::class)->findAll();
        }
        return $this->render('rdv/list.html.twig', [
            'rdvs' => $rdvs,
            'idetud' => 0,
        ]);
    }

    /**
     * @Route("/add/{id}", name="rdv_add", methods="GET|POST")
     */
    public function addRdv(Professeur $professeur, Request $request): Response
    {
        $rdv = new Rdv();
        $form = $this->createForm(RdvType::class, $rdv);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rdv->setHeureDebut($form->get("heureDebut")->getData());
            $rdv->setHeureFin($form->get("heureFin")->getData());
            $rdv->setProfesseur($professeur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rdv);
            $entityManager->flush();
            $rdvs = $this->getDoctrine()->getManager()->getRepository(Rdv::class)->findAll();
            return $this->render('rdv/list.html.twig', [
                'rdvs' => $rdvs,
                'idetud' => 0,
            ]);

        }
        return $this->render('rdv/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/rm/{id}", name="rdv_rm", methods="GET|POST")
     */
    public function rmRdv(Rdv $rdv): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rdv);
            $entityManager->flush();
            return $this->showList();
    }
    /**
     * @Route("/take/{id}", name="rdv_take", methods="GET|POST")
     */
    public function takeRdv(Etudiant $etudiant): Response
    {
        $rdvs = $this->getDoctrine()->getManager()->getRepository(Rdv::class)->findAll();
        return $this->render('rdv/list.html.twig', [
            'idetud' => $etudiant->getId(),
            'rdvs' => $rdvs,
        ]);
    }

    /**
     * @Route("/take/{id}/{id2}", name="rdv_take_2", methods="GET|POST")
     */
    public function takeRdvstep2(Etudiant $etudiant, int $id2): Response
    {
        $rdv = $this->getDoctrine()->getManager()->getRepository(Rdv::class)->find($id2);
        $rdv->setEtudiant($etudiant);
        $etudiant->addRdv($rdv);
        $this->getDoctrine()->getManager()->persist($rdv);
        $this->getDoctrine()->getManager()->persist($etudiant);
        $this->getDoctrine()->getManager()->flush();
        return $this->render('rdv/recap.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    /**
     * @Route("/decom/{id}", name="rdv_decommand", methods="GET|POST")
     */
    public function decommandRdv(Rdv $rdv): Response
    {
        $etudiant = $rdv->getEtudiant();
        $rdv->setEtudiant(null);
        $etudiant->removeRdv($rdv);
        $this->getDoctrine()->getManager()->persist($rdv);
        $this->getDoctrine()->getManager()->flush();
        return $this->showList();
    }


}
