<?php
namespace modele\metier;
class Groupe{
 /**
     * identifiant du groupe
     * @var string
     */
    private $idEtab;
    /**
     * nom du groupe
     * @var string
     */
    private $idTypeChambre;
    /**
     * nom du responsable du groupe
     * @var string 
     */
    private $nombreChambre;
    
   

    function __construct($idEtab, $idTypeChambre, $nombreChambre) {
        $this->idEtab = $idEtab;
        $this->idtypeChambre = $idTypeChambre;
        $this->nombrechambre = $nombreChambre;
        
    }

    function getIdEtab() {
        return $this->idETab;
    }

    function getidTypeChambre() {
        return $this->idTypeChambre;
    }

    function getnombreChambre() {
        return $this->nombreChambre;
    }

    function setIdEtab($idEtab) {
        $this->idEtab = $idEtab;
    }

    function setnombreChambre($nombreChambre) {
        $this->nombreChambre = $nombreChambre;
    }

    function setidTypeCHambre($idTypeChambre) {
        $this->idTypeChambre = $idTypeCHambre;
    }

    


}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

