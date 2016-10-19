
<?php

class Offre{
     
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
        $this->idTypeChambre = $idTypeCHambre;
    }

    


}