<?php

namespace modele\dao;

use modele\metier\Offre;
use PDO;

/**
 * Description of OffreDAO
 * Classe métier :  Offre
 * @author btssio
 */
class DaoOffre implements IDAO {


    protected static function enregVersMetier($enreg) {
        $etab = EtablissementDAO::getOneById($enreg['IDETAB']);
        $typeChambre = TypeChambreDAO::getOneById($enreg['IDTYPECHAMBRE']);
        $nombreChambres = $enreg['NOMBRECHAMBRES'];
        
        $uneOffre = new Offre($etab, $typeChambre, $nombreChambres);

        return $uneOffre;
    }
    
        protected static function metierVersEnreg($objetMetier, $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        $stmt->bindValue(':idEtab', $objetMetier->getEtab()->getId());
        $stmt->bindValue(':idTypeChambre', $objetMetier->getTypeChambre()->getId());
        $stmt->bindValue(':nombreChambres', $objetMetier->getNombreChambres());
        
    }
    
    

    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Offre WHERE IDETAB = :idEtab AND IDTYPECHAMBRE = :idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $id['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['TypeChambre']);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    public static function insert($objet) {
        $requete = "INSERT INTO Offre VALUES (:idEtab, :idTypeChambre, :nombreChambres)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

     public static function update($id, $objet) {
        $ok = false;
        $requete = "UPDATE  Offre SET NOMBRECHAMBRES=:nombreChambres
           WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idEtab', $id['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['TypeChambre']);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM Offre WHERE IDETAB = :idEtab AND IDTYPECHAMBRE=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $id['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['TypeChambre']);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }
    
    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Offre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }
    public static function isAnExistingId($id) {
        $requete = "SELECT COUNT(*) FROM Offre WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $id['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['TypeChambre']);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    
    public static function obtenirNbOffre($idEtab, $idTypeChambre) {
        $requete = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND 
            idTypeChambre=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
        $stmt->execute();
        $ok = $stmt->fetchColumn();
        if ($ok) {
            return $ok;
        } else {
            return 0;
        }
    }
    
    public static function estModifOffreCorrecte($idEtab, $idTypeChambre, $nombreChambres) {
        $nbOccup = AttributionDao::obtenirNbOccup($idEtab, $idTypeChambre);
        return ($nombreChambres >= $nbOccup);
    }

}
