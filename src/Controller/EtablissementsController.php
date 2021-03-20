<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Etablissements;
use App\Entity\Commentaires;



class EtablissementsController extends AbstractController
{
  /**
   * @Route("/etablissements")
   */
  public function affiche(): Response
  {
  	$html = "";
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
      $html .= "<td><a href='/etablissements/Commune/".$item->getid()."'>".$item->getCodeCommune()."</a></td>";
      $html .= "<td><a href='/etablissements/Academie/".$item->getid()."'>".$item->getLibelleAcademie()."</a></td>";
      $html .= '</tr>';
    }
    $html .= "</table>";


    return $this->render('etablissementsController.html.twig', ['tableau' => $html, 'nom' => 'Liste des catégories', 'texte' => '']);

  }

  /**
   * @Route("/etablissements/Departement/{id}")
   */
  public function afficheDepartement($id): Response
  {
    $item = $this
    ->getDoctrine()
    ->getRepository(Etablissements::class)
    ->find($id);

    $html = "<p>Departement : "
    .$item->getLibelleDepartement()
    ." </br> Code département : "
    .$item->getCodeDepartement()
    ." </br> Code ministère : "
    .$item->getCodeMinistere()
    ." </br> Nom ministère : "
    .$item->getLibelleMinistere()
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
        $nomColonnesFait = true;
      }

      $tableau .= "<tr>";
      $tableau .= "<td>".$departement[$i]->getAppelationOfficielle()."</td>";
      $tableau .= "<td>".$departement[$i]->getDenominationPrincipale()."</td>";
      $tableau .= "<td>".$departement[$i]->getDateOuverture()."</td>";
      $tableau .= "<td>".$departement[$i]->getCodeCommune()."</td>";
      $tableau .= "<td>".$departement[$i]->getLibelleAcademie()."</td>";
      $tableau .= "<td>".$departement[$i]->getSecteurPublicPrive()."</td>";
      $tableau .= "<td><a href='/etablissements/Commentaire/".$departement[$i]->getId()."'>Commentaires</a></td>";
      $tableau .= '</tr>';
    }
    $tableau .= "</table>";

    return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Départements', 'texte' => $html]);
  }

  /**
   * @Route("/etablissements/Region/{id}")
   */
  public function afficheRegion($id): Response
  {
  	$item = $this->getDoctrine()->getRepository(Etablissements::class)->find($id);
  	if(!$item) {
  		return new Response("Non trouvé");
  	}

    $region = $this
    ->getDoctrine()
    ->getRepository(Etablissements::class)
    ->findBy(array('libelle_region' => $item->getLibelleRegion()));

    $html = "<p>Code postal : ".$item->getCodePostal()
    ." </br>code region : ".$item->getCodeRegion()
    ." </br>Lieu dit : ".$item->getLieuDit()
    ." </br>Localite : ".$item->getLocalite()
    ." </br>Académie : ".$item->getLibelleAcademie()."</p>";

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
        $nomColonnesFait = true;
      }

      $tableau .= "<tr>";
      $tableau .= "<td>".$region[$i]->getAppelationOfficielle()."</td>";
      $tableau .= "<td>".$region[$i]->getDenominationPrincipale()."</td>";
      $tableau .= "<td>".$region[$i]->getDateOuverture()."</td>";
      $tableau .= "<td>".$region[$i]->getCodeCommune()."</td>";
      $tableau .= "<td>".$region[$i]->getLibelleAcademie()."</td>";
      $tableau .= "<td>".$region[$i]->getSecteurPublicPrive()."</td>";
      $tableau .= "<td><a href='/etablissements/Commentaire/".$region[$i]->getId()."'>Commentaires</a></td>";
      $tableau .= '</tr>';
    }
    $tableau .= "</table>";

  	return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Régions', 'texte' => $html]);
  }

  /**
   * @Route("/etablissements/Commune/{id}")
   */
  public function afficheCommune($id): Response
  {
  	$item = $this->getDoctrine()->getRepository(Etablissements::class)->find($id);
  	if(!$item) {
  		return new Response("Non trouvé");
  	}

    $commune = $this
    ->getDoctrine()
    ->getRepository(Etablissements::class)
    ->findBy(array('code_commune' => $item->getCodeCommune()));

    $html = "<p>Code postal : ".$item->getCodePostal()
    ." </br>code département : ".$item->getCodeDepartement()
    ." </br>Appelation officielle : ".$item->getAppelationOfficielle()
    ." </br>Lieu dit : ".$item->getLieuDit()
    ." </br>Localite : ".$item->getLocalite()
    ." </br>Académie : ".$item->getLibelleAcademie()."</p>";

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
        $nomColonnesFait = true;
      }

      $tableau .= "<tr>";
      $tableau .= "<td>".$commune[$i]->getAppelationOfficielle()."</td>";
      $tableau .= "<td>".$commune[$i]->getDenominationPrincipale()."</td>";
      $tableau .= "<td>".$commune[$i]->getDateOuverture()."</td>";
      $tableau .= "<td>".$commune[$i]->getCodeCommune()."</td>";
      $tableau .= "<td>".$commune[$i]->getLibelleAcademie()."</td>";
      $tableau .= "<td>".$commune[$i]->getSecteurPublicPrive()."</td>";
      $tableau .= "<td><a href='/etablissements/Commentaire/".$commune[$i]->getId()."'>Commentaires</a></td>";
      $tableau .= '</tr>';
    }
    $tableau .= "</table>";

  	return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Communes', 'texte' => $html]);
  }

  /**
   * @Route("/etablissements/Academie/{codeAcademie}")
   */

  public function afficheAcademie($codeAcademie) : Response
  {
    $item = $this->getDoctrine()
    ->getRepository(Etablissements::class)
    ->find($codeAcademie);

    if(!$item) {
      return new Response("Non trouvé");
    }

    $academie = $this
    ->getDoctrine()
    ->getRepository(Etablissements::class)
    ->findBy(array('libelle_academie' => $item->getLibelleAcademie()));

    $html = "<p>Code postal : "
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
        $nomColonnesFait = true;
      }

      $tableau .= "<tr>";
      $tableau .= "<td>".$academie[$i]->getAppelationOfficielle()."</td>";
      $tableau .= "<td>".$academie[$i]->getDenominationPrincipale()."</td>";
      $tableau .= "<td>".$academie[$i]->getDateOuverture()."</td>";
      $tableau .= "<td>".$academie[$i]->getCodeCommune()."</td>";
      $tableau .= "<td>".$academie[$i]->getLibelleAcademie()."</td>";
      $tableau .= "<td>".$academie[$i]->getSecteurPublicPrive()."</td>";
      $tableau .= "<td><a href='/etablissements/Commentaire/".$academie[$i]->getId()."'>Commentaires</a></td>";
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
   * @Route("/etablissements/Commentaire/{id}")
   */

  public function afficheCommentaireEtablissement($id) : Response
  {
  	$etablissement = $this
    ->getDoctrine()
    ->getRepository(Etablissements::class)
    ->find($id);
    
    $commentaires = $etablissement->getCommentaires();

    $tableau  = "<tr>";
    $tableau .= "<th>Etablissement</th>";
    $tableau .= "<th>Pseudo</th>";
    $tableau .= "<th>Date</th>";
    $tableau .= "<th>Note</th>";
    $tableau .= "<th>Commentaire</th>";

    for($i = 0; $i < $commentaires->count(); $i++) {
		$tableau .= "<tr>";
		$tableau .= "<td>".$etablissement->getAppelationOfficielle()."</td>";
		$tableau .= "<td>".$commentaires[$i]->getNom()."</td>";
		$tableau .= "<td>".$commentaires[$i]->getDateCreation()->format('Y-m-d')."</td>";
		$tableau .= "<td>".$commentaires[$i]->getNote()." ☆ </td>";
		$tableau .= "<td></td>";
		$tableau .= "</tr>";
    }

    $html = $etablissement->getAppelationOfficielle()."</br>
    <a href='/etablissements/Commentaire/ajout/".$etablissement->getId()."'>Ajouter un commentaire</a>";

    return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Commentaires', 'texte' => $html]);
  }
}