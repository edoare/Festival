
<?php
namespace \modele\metier;

class Offre{
    
    private $idEtab;
    
    private $idTypeChambre;
    
    private $nombreChambre;
    
   

    function __construct($idEtab, $idTypeChambre, $nombreChambre) {
        $this->idEtab = $idEtab;
        $this->idtypeChambre = $idTypeChambre;
        $this->nombrechambre = $nombreChambre;
        
    }

    function getIdEtab() {
        return $this->idETab;
    }

    function getIdTypeChambre() {
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

    function setIdTypeCHambre($idTypeChambre) {
        $this->idTypeChambre = $idTypeChambre;
    }

    


}