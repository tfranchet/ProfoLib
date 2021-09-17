<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Professeur;
use App\Entity\Rdv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heureDebut')
            ->add('heureFin')
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => function ($etudiant) {
                    return $etudiant->getName();
                }
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => function ($professeur) {
                    return $professeur->getName();
                }
            ])
            ->add('submit', SubmitType::class, ['label' => 'Create Task'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
