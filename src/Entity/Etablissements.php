<?php

namespace App\Entity;

use App\Repository\EtablissementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EtablissementsRepository::class)
 */
class Etablissements
{

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255)
     */
    private $appelation_officielle;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255)
     */
    private $denomination_principale;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $patronyme;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", columnDefinition="enum('Public','Prive')")
     */
    private $secteur_public_prive;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $addresse;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_dit;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $boite_postale;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer")
     */
    private $code_postal;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255)
     */
    private $localite;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $coorX;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $coorY;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $epsg;

    /**
     * @ORM\Column(type="float")
     *
     *  @Assert\Range(
     *      min = -90,
     *      max = 90,
     *      notInRangeMessage = "La latitude doit avoir une valeur entre {{ min }} et {{ max }} degres",
     * )
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     *
     * @Assert\Range(
     *     min = 0,
     *      max = 180,
     *      notInRangeMessage = "La longitude doit avoir une valeur entre {{ min }} et {{ max }} degres",
     * )
     */
    private $longitude;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $appariement;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localisation;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nature_uai;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nature_uai_libe;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat_etablissement;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat_etablissement_libe;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer")
     */
    private $code_departement;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer")
     */
    private $code_region;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer")
     */
    private $code_academie;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer")
     */
    private $code_commune;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle_departement;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle_region;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle_academie;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $position;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="float")
     */
    private $secteur_prive_code_type_contrat;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $secteur_prive_libelle_type_contrat;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code_ministere;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $libelle_ministere;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $date_ouverture;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="etablissement")
     */
    private $commentaires;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle_commune;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAppelationOfficielle(): ?string
    {
        return $this->appelation_officielle;
    }

    public function setAppelationOfficielle(string $appelation_officielle): self
    {
        $this->appelation_officielle = $appelation_officielle;

        return $this;
    }

    public function getDenominationPrincipale(): ?string
    {
        return $this->denomination_principale;
    }

    public function setDenominationPrincipale(string $denomination_principale): self
    {
        $this->denomination_principale = $denomination_principale;

        return $this;
    }

    public function getPatronyme(): ?string
    {
        return $this->patronyme;
    }

    public function setPatronyme(string $patronyme): self
    {
        $this->patronyme = $patronyme;

        return $this;
    }

    public function getSecteurPublicPrive(): ?string
    {
        return $this->secteur_public_prive;
    }

    public function setSecteurPublicPrive(string $secteur_public_prive): self
    {
        $this->secteur_public_prive = $secteur_public_prive;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getLieuDit(): ?string
    {
        return $this->lieu_dit;
    }

    public function setLieuDit(?string $lieu_dit): self
    {
        $this->lieu_dit = $lieu_dit;

        return $this;
    }

    public function getBoitePostale(): ?int
    {
        return $this->boite_postale;
    }

    public function setBoitePostale(?int $boite_postale): self
    {
        $this->boite_postale = $boite_postale;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getCoorX(): ?float
    {
        return $this->coorX;
    }

    public function setCoorX(float $coorX): self
    {
        $this->coorX = $coorX;

        return $this;
    }

    public function getCoorY(): ?float
    {
        return $this->coorY;
    }

    public function setCoorY(float $coorY): self
    {
        $this->coorY = $coorY;

        return $this;
    }

    public function getEpsg(): ?string
    {
        return $this->epsg;
    }

    public function setEpsg(?string $epsg): self
    {
        $this->epsg = $epsg;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAppariement(): ?string
    {
        return $this->appariement;
    }

    public function setAppariement(string $appariement): self
    {
        $this->appariement = $appariement;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getNatureUai(): ?string
    {
        return $this->nature_uai;
    }

    public function setNatureUai(?string $nature_uai): self
    {
        $this->nature_uai = $nature_uai;

        return $this;
    }

    public function getNatureUaiLibe(): ?string
    {
        return $this->nature_uai_libe;
    }

    public function setNatureUaiLibe(?string $nature_uai_libe): self
    {
        $this->nature_uai_libe = $nature_uai_libe;

        return $this;
    }

    public function getEtatEtablissement(): ?string
    {
        return $this->etat_etablissement;
    }

    public function setEtatEtablissement(?string $etat_etablissement): self
    {
        $this->etat_etablissement = $etat_etablissement;

        return $this;
    }

    public function getEtatEtablissementLibe(): ?string
    {
        return $this->etat_etablissement_libe;
    }

    public function setEtatEtablissementLibe(?string $etat_etablissement_libe): self
    {
        $this->etat_etablissement_libe = $etat_etablissement_libe;

        return $this;
    }

    public function getCodeDepartement(): ?int
    {
        return $this->code_departement;
    }

    public function setCodeDepartement(int $code_departement): self
    {
        $this->code_departement = $code_departement;

        return $this;
    }

    public function getCodeRegion(): ?int
    {
        return $this->code_region;
    }

    public function setCodeRegion(int $code_region): self
    {
        $this->code_region = $code_region;

        return $this;
    }

    public function getCodeAcademie(): ?int
    {
        return $this->code_academie;
    }

    public function setCodeAcademie(int $code_academie): self
    {
        $this->code_academie = $code_academie;

        return $this;
    }

    public function getCodeCommune(): ?int
    {
        return $this->code_commune;
    }

    public function setCodeCommune(int $code_commune): self
    {
        $this->code_commune = $code_commune;

        return $this;
    }

    public function getLibelleDepartement(): ?string
    {
        return $this->libelle_departement;
    }

    public function setLibelleDepartement(?string $libelle_departement): self
    {
        $this->libelle_departement = $libelle_departement;

        return $this;
    }

    public function getLibelleRegion(): ?string
    {
        return $this->libelle_region;
    }

    public function setLibelleRegion(?string $libelle_region): self
    {
        $this->libelle_region = $libelle_region;

        return $this;
    }

    public function getLibelleAcademie(): ?string
    {
        return $this->libelle_academie;
    }

    public function setLibelleAcademie(?string $libelle_academie): self
    {
        $this->libelle_academie = $libelle_academie;

        return $this;
    }

    public function getPosition(): ?float
    {
        return $this->position;
    }

    public function setPosition(float $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getSecteurPriveCodeTypeContrat(): ?float
    {
        return $this->secteur_prive_code_type_contrat;
    }

    public function setSecteurPriveCodeTypeContrat(float $secteur_prive_code_type_contrat): self
    {
        $this->secteur_prive_code_type_contrat = $secteur_prive_code_type_contrat;

        return $this;
    }

    public function getSecteurPriveLibelleTypeContrat(): ?int
    {
        return $this->secteur_prive_libelle_type_contrat;
    }

    public function setSecteurPriveLibelleTypeContrat(?int $secteur_prive_libelle_type_contrat): self
    {
        $this->secteur_prive_libelle_type_contrat = $secteur_prive_libelle_type_contrat;

        return $this;
    }

    public function getCodeMinistere(): ?string
    {
        return $this->code_ministere;
    }

    public function setCodeMinistere(?string $code_ministere): self
    {
        $this->code_ministere = $code_ministere;

        return $this;
    }

    public function getLibelleMinistere(): ?String
    {
        return $this->libelle_ministere;
    }

    public function setLibelleMinistere(?String $libelle_ministere): self
    {
        $this->libelle_ministere = $libelle_ministere;

        return $this;
    }

    public function getDateOuverture(): ?int
    {
        return $this->date_ouverture;
    }

    public function setDateOuverture(?int $date_ouverture): self
    {
        $this->date_ouverture = $date_ouverture;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setEtablissement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtablissement() === $this) {
                $commentaire->setEtablissement(null);
            }
        }

        return $this;
    }

    public function getLibelleCommune(): ?string
    {
        return $this->libelle_commune;
    }

    public function setLibelleCommune(?string $libelle_commune): self
    {
        $this->libelle_commune = $libelle_commune;

        return $this;
    }
}
