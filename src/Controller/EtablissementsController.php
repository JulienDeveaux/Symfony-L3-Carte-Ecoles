<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Etablissements;


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

    for($i = 12860; $i < 12901; $i++) {
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
        $html .= "<td><a href='/etablissements/departement/".$item->getid()."'>".$item->getLibelleDepartement()."</a></td>";
        $html .= "<td><a href='/etablissements/Region/".$item->getid()."'>".$item->getLibelleRegion()."</a></td>";
        $html .= "<td><a href='/etablissements/Commune/".$item->getid()."'>".$item->getCodeCommune()."</a></td>";
        $html .= "<td><a href='/etablissements/Academie/".$item->getid()."'>".$item->getLibelleAcademie()."</a></td>";
        $html .= '</tr>';
    }
    $html .= "</table>";


    return new Response ($html);
  }

  /**
   * @Route("/etablissements/departement/{id}")
   */
  public function afficheDepartement($id): Response
  {
  	$item = $this->getDoctrine()->getRepository(Etablissements::class)->find($id);
  	if(!$item) {
  		return new Response("Non trouvé");
  	}
  	return new Response("<p>Code postal : ".$item->getCodePostal()." </br>code département : ".$item->getCodeDepartement()." </br>Appelation officielle : ".$item->getAppelationOfficielle()." </br>Lieu dit : ".$item->getLieuDit()." </br>Localite : ".$item->getLocalite()." </br>Académie : ".$item->getLibelleAcademie()."</p>");
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
  	return new Response("<p>Code postal : ".$item->getCodePostal()." </br>code département : ".$item->getCodeDepartement()." </br>Appelation officielle : ".$item->getAppelationOfficielle()." </br>Lieu dit : ".$item->getLieuDit()." </br>Localite : ".$item->getLocalite()." </br>Académie : ".$item->getLibelleAcademie()."</p>");
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
  	return new Response("<p>Code postal : ".$item->getCodePostal()." </br>code département : ".$item->getCodeDepartement()." </br>Appelation officielle : ".$item->getAppelationOfficielle()." </br>Lieu dit : ".$item->getLieuDit()." </br>Localite : ".$item->getLocalite()." </br>Académie : ".$item->getLibelleAcademie()."</p>");
  }

  /**
   * @Route("/")
   */
  public function index(): RedirectResponse
  {
      return $this->redirectToRoute("/etablissements");
  }
    /**
     * @Route("/etablissements/academie/{codeAcademie}")
     */

    public function afficheAcademie($codeAcademie) : Response
    {
        $item = $this->getDoctrine()
            ->getRepository(Etablissements::class)
            ->find($codeAcademie);
        if(!$item) {
            return new Response("Non trouvé");
        }
        return new Response("<p>Code postal : "
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
            ."</p>");

    }


}
