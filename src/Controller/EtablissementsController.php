<?php
namespace App\Controller;


use App\Form\EtablissementType;
use DateTime;
use DateTimeInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Etablissements;
use App\Entity\Commentaires;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class EtablissementsController extends AbstractController
{
    /**
     * @Route("/etablissements", name="affiche")
     */
    public function affiche(): Response
    {
        session_start();
        $_SESSION['id'] = "";
        $_SESSION['route'] = "affiche";
        $html = "";
        $html .= "</br> <a href='/etablissements/Ajouter/'> Ajouter un établissement</a>";
        $html .= "<table>";
        $nomColonnesFait = false;

        $maxId = $this
            ->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('MAX(e.id)')
            ->from('App:Etablissements', 'e')
            ->getQuery()
            ->getSingleScalarResult();

        $minId = $this
            ->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('MIN(e.id)')
            ->from('App:Etablissements', 'e')
            ->getQuery()
            ->getSingleScalarResult();

        for($i = $minId; $i < $maxId; $i++) {
            $item = $this->getDoctrine()->getRepository(Etablissements::class)->find($i);
            if(!$nomColonnesFait){
                $html .= "<tr>";
                $html .= "<th>Département</th>";
                $html .= "<th>Région</th>";
                $html .= "<th>Commune</th>";
                $html .= "<th>Académie</th>";
                $nomColonnesFait = true;
            }

            $html .= "<tr>";
            $html .= "<td><a href='/etablissements/Departement/".$item->getid()."'>".$item->getLibelleDepartement()."</a></td>";
            $html .= "<td><a href='/etablissements/Region/".$item->getid()."'>".$item->getLibelleRegion()."</a></td>";
            $html .= "<td><a href='/etablissements/Commune/".$item->getid()."'>".$item->getLibelleCommune()."</a></td>";
            $html .= "<td><a href='/etablissements/Academie/".$item->getid()."'>".$item->getLibelleAcademie()."</a></td>";
            $html .= '</tr>';
        }
        $html .= "</table>";


        return $this->render('etablissementsController.html.twig', ['tableau' => $html, 'nom' => 'Liste des catégories', 'texte' => '']);

    }

    /**
     * @Route("/etablissements/Departement/{id}", name="departementDetail")
     */
    public function afficheDepartement($id): Response
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['route'] = "departementDetail";
        $item = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->find($id);

        $html = "<p><a href='/etablissements/'>Retour à la liste principale</a>"
            ." </br> Departement : "
            .$item->getLibelleDepartement()
            ." </br> Code département : "
            .$item->getCodeDepartement()
            ." </br> Code ministère : "
            .$item->getCodeMinistere()
            ." </br> Nom ministère : "
            .$item->getLibelleMinistere()
            ."</br> <a href='/etablissements/Ajouter/'> Ajouter un établissement</a>"
            ."</p>";

        if(!$item) {
            return new Response("Non trouvé");
        }

        $departement = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->findBy(array('libelle_departement' => $item->getLibelleDepartement()));

        $tableau = "";
        $tableau .= "<table>";
        $nomColonnesFait = false;

        for($i = 0; $i < sizeof($departement); $i++) {
            if(!$nomColonnesFait){
                $tableau .= "<tr>";
                $tableau .= "<th>Etablissement</th>";
                $tableau .= "<th>Type</th>";
                $tableau .= "<th>Date d'ouverture</th>";
                $tableau .= "<th>Commune</th>";
                $tableau .= "<th>Académie</th>";
                $tableau .= "<th>Privé / Public</th>";
                $tableau .= "<th>Commentaire</th>";
                $tableau .= "<th>Modification</th>";
                $nomColonnesFait = true;
            }

            $tableau .= "<tr>";
            $tableau .= "<td>".$departement[$i]->getAppelationOfficielle()."</td>";
            $tableau .= "<td>".$departement[$i]->getDenominationPrincipale()."</td>";
            $tableau .= "<td>".$departement[$i]->getDateOuverture()."</td>";
            $tableau .= "<td><a href='/etablissements/Commune/".$departement[$i]->getId()."'>".$departement[$i]->getLibelleCommune()."</a></td>";
            $tableau .= "<td>".$departement[$i]->getLibelleAcademie()."</td>";
            $tableau .= "<td>".$departement[$i]->getSecteurPublicPrive()."</td>";
            $tableau .= "<td><a href='/etablissements/Commentaire/".$departement[$i]->getId()."'>Commentaires</a></td>";
            $tableau .= "<td><a href='/etablissements/Modifier/".$departement[$i]->getId()."'>Modification</a></td>";
            $tableau .= '</tr>';
        }
        $tableau .= "</table>";

        return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Départements', 'texte' => $html]);
    }

    /**
     * @Route("/etablissements/Region/{id}", name="regionDetail")
     */
    public function afficheRegion($id): Response
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['route'] = "regionDetail";
        $item = $this->getDoctrine()->getRepository(Etablissements::class)->find($id);
        if(!$item) {
            return new Response("Non trouvé");
        }

        $region = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->findBy(array('libelle_region' => $item->getLibelleRegion()));

        $html = "<p><a href='/etablissements/'>Retour à la liste principale</a>"
            ." </br>Code postal : ".$item->getCodePostal()
            ." </br>code region : ".$item->getCodeRegion()
            ." </br>Lieu dit : ".$item->getLieuDit()
            ." </br>Localite : ".$item->getLocalite()
            ." </br>Académie : ".$item->getLibelleAcademie()
            ."</br> <a href='/etablissements/Ajouter/'> Ajouter un établissement</a>"
            ."</p>";

        $tableau = "";
        $tableau .= "<table>";
        $nomColonnesFait = false;

        for($i = 0; $i < sizeof($region); $i++) {
            if(!$nomColonnesFait){
                $tableau .= "<tr>";
                $tableau .= "<th>Etablissement</th>";
                $tableau .= "<th>Type</th>";
                $tableau .= "<th>Date d'ouverture</th>";
                $tableau .= "<th>Commune</th>";
                $tableau .= "<th>Académie</th>";
                $tableau .= "<th>Privé / Public</th>";
                $tableau .= "<th>Commentaire</th>";
                $tableau .= "<th>Modification</th>";
                $nomColonnesFait = true;
            }

            $tableau .= "<tr>";
            $tableau .= "<td>".$region[$i]->getAppelationOfficielle()."</td>";
            $tableau .= "<td>".$region[$i]->getDenominationPrincipale()."</td>";
            $tableau .= "<td>".$region[$i]->getDateOuverture()."</td>";
            $tableau .= "<td><a href='/etablissements/Commune/".$region[$i]->getId()."'>".$region[$i]->getLibelleCommune()."</a></td>";
            $tableau .= "<td>".$region[$i]->getLibelleAcademie()."</td>";
            $tableau .= "<td>".$region[$i]->getSecteurPublicPrive()."</td>";
            $tableau .= "<td><a href='/etablissements/Commentaire/".$region[$i]->getId()."'>Commentaires</a></td>";
            $tableau .= "<td><a href='/etablissements/Modifier/".$region[$i]->getId()."'>Modification</a></td>";
            $tableau .= '</tr>';
        }
        $tableau .= "</table>";

        return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Régions', 'texte' => $html]);
    }

    /**
     * @Route("/etablissements/Commune/{id}", name="communeDetail")
     */
    public function afficheCommune($id): Response
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['route'] = "communeDetail";
        $item = $this->getDoctrine()->getRepository(Etablissements::class)->find($id);
        if(!$item) {
            return new Response("Non trouvé");
        }

        $commune = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->findBy(array('code_commune' => $item->getCodeCommune()));

        $html = "<p><a href='/etablissements/'>Retour à la liste principale</a>"
            ." </br><a href='/etablissements/cartographieCommune/".$item->getId()."'>Carte des emplacements de établissements</a>"
            ." </br>Code postal : ".$item->getCodePostal()
            ." </br>code département : ".$item->getCodeDepartement()
            ." </br>Appelation officielle : ".$item->getAppelationOfficielle()
            ." </br>Lieu dit : ".$item->getLieuDit()
            ." </br>Localite : ".$item->getLocalite()
            ." </br>Académie : ".$item->getLibelleAcademie()
            ." </br> <a href='/etablissements/Ajouter/'> Ajouter un établissement</a>"
            ."</p>";

        $tableau = "";
        $tableau .= "<table>";
        $nomColonnesFait = false;

        for($i = 0; $i < sizeof($commune); $i++) {
            if(!$nomColonnesFait){
                $tableau .= "<tr>";
                $tableau .= "<th>Etablissement</th>";
                $tableau .= "<th>Type</th>";
                $tableau .= "<th>Date d'ouverture</th>";
                $tableau .= "<th>Commune</th>";
                $tableau .= "<th>Académie</th>";
                $tableau .= "<th>Privé / Public</th>";
                $tableau .= "<th>Commentaire</th>";
                $tableau .= "<th>Modification</th>";
                $nomColonnesFait = true;
            }

            $tableau .= "<tr>";
            $tableau .= "<td>".$commune[$i]->getAppelationOfficielle()."</td>";
            $tableau .= "<td>".$commune[$i]->getDenominationPrincipale()."</td>";
            $tableau .= "<td>".$commune[$i]->getDateOuverture()."</td>";
            $tableau .= "<td>".$commune[$i]->getLibelleCommune()."</td>";
            $tableau .= "<td>".$commune[$i]->getLibelleAcademie()."</td>";
            $tableau .= "<td>".$commune[$i]->getSecteurPublicPrive()."</td>";
            $tableau .= "<td><a href='/etablissements/Commentaire/".$commune[$i]->getId()."'>Commentaires</a></td>";
            $tableau .= "<td><a href='/etablissements/Modifier/".$commune[$i]->getId()."'>Modification</a></td>";
            $tableau .= '</tr>';
        }
        $tableau .= "</table>";

        return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Communes', 'texte' => $html]);
    }

    /**
     * @Route("/etablissements/Academie/{id}", name="academieDetail")
     */

    public function afficheAcademie($id) : Response
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['route'] = "academieDetail";
        $item = $this->getDoctrine()
            ->getRepository(Etablissements::class)
            ->find($id);

        if(!$item) {
            return new Response("Non trouvé");
        }

        $academie = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->findBy(array('libelle_academie' => $item->getLibelleAcademie()));

        $html = "<p><a href='/etablissements/'>Retour à la liste principale</a>"
            ." </br>Code postal : "
            .$item->getCodePostal()
            ." </br>code département : "
            .$item->getCodeDepartement()
            ." </br>Appelation officielle : "
            .$item->getAppelationOfficielle()
            ." </br>Lieu dit : "
            .$item->getLieuDit()
            ." </br>Localite : "
            .$item->getLocalite()
            ." </br>Académie : "
            .$item->getLibelleAcademie()
            ."</br> <a href='/etablissements/Ajouter/'> Ajouter un établissement</a>"
            ."</p>";

        $tableau = "";
        $tableau .= "<table>";
        $nomColonnesFait = false;

        for($i = 0; $i < sizeof($academie); $i++) {
            if(!$nomColonnesFait){
                $tableau .= "<tr>";
                $tableau .= "<th>Etablissement</th>";
                $tableau .= "<th>Type</th>";
                $tableau .= "<th>Date d'ouverture</th>";
                $tableau .= "<th>Commune</th>";
                $tableau .= "<th>Académie</th>";
                $tableau .= "<th>Privé / Public</th>";
                $tableau .= "<th>Commentaire</th>";
                $tableau .= "<th>Modification</th>";
                $nomColonnesFait = true;
            }

            $tableau .= "<tr>";
            $tableau .= "<td>".$academie[$i]->getAppelationOfficielle()."</td>";
            $tableau .= "<td>".$academie[$i]->getDenominationPrincipale()."</td>";
            $tableau .= "<td>".$academie[$i]->getDateOuverture()."</td>";
            $tableau .= "<td><a href='/etablissements/Commune/".$academie[$i]->getId()."'>".$academie[$i]->getLibelleCommune()."</a></td>";
            $tableau .= "<td>".$academie[$i]->getLibelleAcademie()."</td>";
            $tableau .= "<td>".$academie[$i]->getSecteurPublicPrive()."</td>";
            $tableau .= "<td><a href='/etablissements/Commentaire/".$academie[$i]->getId()."'>Commentaires</a></td>";
            $tableau .= "<td><a href='/etablissements/Modifier/".$academie[$i]->getId()."'>Modification</a></td>";
            $tableau .= '</tr>';
        }
        $tableau .= "</table>";

        return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Académie', 'texte' => $html]);
    }

    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return new Response ("<meta http-equiv='refresh' content='0; URL=/etablissements'>");
    }



    /**
     * @Route("/etablissements/cartographieCommune/{id}")
     */
    public function carteographieCommune($id): Response
    {
        $commune = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->find($id);

        $etablissementsCommune = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->findBy(array('code_commune' => $commune->getCodeCommune()));

        $html = "";

    for($i = 0; $i < sizeof($etablissementsCommune);$i++) {
        $html .= '{nom:"'.$etablissementsCommune[$i]->getAppelationOfficielle().'",lat:"'.$etablissementsCommune[$i]->getLatitude().'",lon:"'.$etablissementsCommune[$i]->getLongitude().'"},';

        }

        return $this->render('map.html.twig', ['nom' => 'Localisation des Etablissements '.$commune->getLibelleCommune(), 'html' => $html]);
    }

    /**
     * @Route("/etablissements/Modifier/{id}")
     */
    public function modifierEtablissement($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $etablissement = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->find($id);

        $maxId = $this
            ->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('MAX(e.id)')
            ->from('App:Etablissements', 'e')
            ->getQuery()
            ->getSingleScalarResult();

        if($id == -1){
            $etablissement = new Etablissements();
            $etablissement->setId($maxId + 1);
        }

        $etablissementForm = $this->createForm(EtablissementType::class, $etablissement)
            ->add('save', SubmitType::class, array('label' => 'OK'));
        $etablissementForm->handleRequest($request);


        if ($etablissementForm->isSubmitted() && $etablissementForm->isValid()) {
            $etablissement = $etablissementForm->getData();
            $manager->persist($etablissement);
            $manager->flush();
            return $this->redirectToRoute($_SESSION['route'], ['id' => $_SESSION['id']]);
        }

        if($id == -1) {
            return $this->render('form.html.twig', ['etat' => 'Ajouter l\'établissement',
                'form' => $etablissementForm->createView()
            ]);
        } else {
            return $this->render('form.html.twig', ['etat' => 'Modifier l\'établissement',
                'form' => $etablissementForm->createView()
            ]);
        }
    }

    /**
     * @Route("/etablissements/Ajouter/")
     *
     */
    public function ajouterEtablissemet(Request $request):Response
    {

        return $this->modifierEtablissement( -1, $request);
    }

 }