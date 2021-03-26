<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\Etablissements;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    /**
     * @Route("/etablissements/Commentaire/{id}", name="CommentaireAffiche")
     */

    public function afficheCommentaireEtablissement($id): Response
    {
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['route'] = "CommentaireAffiche";
        $etablissement = $this
            ->getDoctrine()
            ->getRepository(Etablissements::class)
            ->find($id);

        $commentaires = $etablissement->getCommentaires();

        $tableau = "<tr>";
        $tableau .= "<th>Etablissement</th>";
        $tableau .= "<th>Pseudo</th>";
        $tableau .= "<th>Date</th>";
        $tableau .= "<th>Note</th>";
        $tableau .= "<th>Commentaire</th>";
        $tableau .= "<th>Modification</th>";

        for ($i = 0; $i < $commentaires->count(); $i++) {
            $tableau .= "<tr>";
            $tableau .= "<td>" . $etablissement->getAppelationOfficielle() . "</td>";
            $tableau .= "<td>" . $commentaires[$i]->getNom() . "</td>";
            $tableau .= "<td>" . $commentaires[$i]->getDateCreation()->format('Y-m-d') . "</td>";
            $tableau .= "<td>" . $commentaires[$i]->getNote() . " ☆ </td>";
            $tableau .= "<td>" . $commentaires[$i]->getTexte() ."</td>";
            $tableau .= "<td><a href='/Commentaire/ModifierCommentaire/" . $commentaires[$i]->getId() . "'>Modification</a></td>";
            $tableau .= "</tr>";
        }

        $html = $etablissement->getAppelationOfficielle()
            . "</br> <a href='/Commentaire/AjouterCommentaire/".$etablissement->getId()
            . "'>Ajouter un commentaire</a>"
            . " </br><a href='/etablissements/'>Retour à la liste principale</a>";

        return $this->render('etablissementsController.html.twig', ['tableau' => $tableau, 'nom' => 'Commentaires', 'texte' => $html]);
    }

    /**
     * @Route("/Commentaire/ModifierCommentaire/{id}")
     */
    public function modifierCommentaire($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $commentaire = $this
            ->getDoctrine()
            ->getRepository(Commentaires::class)
            ->find($id);

        $maxId = $this
            ->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('MAX(e.id)')
            ->from('App:Commentaires', 'e')
            ->getQuery()
            ->getSingleScalarResult();

        if ($id == -1) {
            $commentaire = new Commentaires();
            $commentaire->setId($maxId + 1);
        }

        $commentaireForm = $this->createForm(CommentaireType::class, $commentaire)
            ->add('save', SubmitType::class, array('label' => 'OK'));
        $commentaireForm->handleRequest($request);


        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {
            $commentaire = $commentaireForm->getData();
            $etablissements = $this
                ->getDoctrine()
                ->getRepository(Etablissements::class)
                ->find($_SESSION['idEtablissement']);
            $etablissements->addCommentaire($commentaire);
            $manager->persist($commentaire);
            $manager->persist($etablissements);
            $manager->flush();
            return $this->redirectToRoute($_SESSION['route'], ['id' => $_SESSION['id']]);
        }
        if ($id == -1) {
            return $this->render('form.html.twig', ['etat' => 'Ajouter un commentaire',
                'form' => $commentaireForm->createView()
            ]);
        } else {
            return $this->render('form.html.twig', ['etat' => 'Modifier un commentaire',
                'form' => $commentaireForm->createView()
            ]);
        }
    }

    /**
     * @Route("/Commentaire/AjouterCommentaire/{id}")
     *
     */
    public function ajouterCommentaire(Request $request, $id): Response
    {
        $_SESSION['idEtablissement'] = $id;
        return $this->modifierCommentaire(-1, $request);
    }

}