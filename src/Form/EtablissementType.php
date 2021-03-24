<?php

namespace App\Form;

use App\Entity\Etablissements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appelation_officielle')
            ->add('denomination_principale')
            ->add('patronyme')
            ->add('secteur_public_prive')
            ->add('addresse')
            ->add('lieu_dit')
            ->add('boite_postale')
            ->add('code_postal')
            ->add('localite')
            ->add('coorX')
            ->add('coorY')
            ->add('epsg')
            ->add('latitude')
            ->add('longitude')
            ->add('appariement')
            ->add('localisation')
            ->add('nature_uai')
            ->add('nature_uai_libe')
            ->add('etat_etablissement')
            ->add('etat_etablissement_libe')
            ->add('code_departement')
            ->add('code_region')
            ->add('code_academie')
            ->add('code_commune')
            ->add('libelle_departement')
            ->add('libelle_region')
            ->add('libelle_academie')
            ->add('position')
            ->add('secteur_prive_code_type_contrat')
            ->add('secteur_prive_libelle_type_contrat')
            ->add('code_ministere')
            ->add('libelle_ministere')
            ->add('date_ouverture')
            ->add('libelle_commune')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etablissements::class,
        ]);
    }

}
