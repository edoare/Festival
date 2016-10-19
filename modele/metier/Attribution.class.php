<?php
namespace modele\metier;

/**
 * Description d'Attribution
 * attribution des chambres pour les groupes
 * @author btssio
 */
class Attribution {
    /**
     * code  de 8 caractères alphanum.
     * @var string
     */
    private $idEtab;
    /**
     * Type de l'établissement
     * @var string
     */
    private $idTypeChambre;
    /**
     * Type de la chambre
     * @var string
     */
    private $idGroupe;
    /**
     * Nom du groupe
     * @var string 
     */
    private $nbChambres;
    /**
     * Nombre de chambres
     * @var integer
     */
    
    function __construct($idEtab, $idTypeChambre, $idGroupe, $nbChambres) {
        $this->idEtab = $idEtab;
        $this->idTypeChambre = $idTypeChambre;
        $this->idGroupe= $idGroupe;
        $this->nbChambres = $nbChambres;

    }

    function getIdEtab() {
        return $this->idEtab;
    }

    function getidTypeChambre() {
        return $this->idTypeChambre;
    }

    function getidGroupe() {
        return $this->idGroupe;
    }

    function getnbChambres() {
        return $this->nbChambres;
    }

    function setIdEtab($idEtab) {
        $this->idEtab = $idEtab;
    }

    function setidTypeChambre($idTypeChambre) {
        $this->idTypeChambre = $idTypeChambre;
    }

    function setidGroupe($idGroupe) {
        $this->idGroupe = $idGroupe;
    }

    function setnbChambres($nbChambres) {
        $this->nbChambres = $nbChambres;
    } 
}

