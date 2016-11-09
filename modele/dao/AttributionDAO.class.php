<?php

namespace modele\dao;

use modele\metier\Attribution;
use PDO;

/**
 * Description of AttributionDAO
 * Classe métier : Attribution
 * @author btssio
 */
class AttributionDAO implements IDAO {

    protected static function enregVersMetier($enreg) {
        $idEtab = $enreg['idEtab'];
        $idTypeChambre = $enreg['idTypeChambre'];
        $idGroupe = $enreg[strtoupper('idGroupe')];
        $nbChambres = $enreg[strtoupper('nombreChambres')];

        $uneattribution = new Attribution($idEtab, $idTypeChambre, $idGroupe, $nbChambres);

        return $uneattribution;
    }

    protected static function metierVersEnreg($objetMetier, $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        $stmt->bindValue(':idEtab', $objetMetier->getidEtab());
        $stmt->bindValue(':idTypeChambre', $objetMetier->getidTypeChambre());
        $stmt->bindValue(':idGroupe', $objetMetier->getidGroupe());
        $stmt->bindValue(':nbChambres', $objetMetier->getnbChambres());
    }

    public static function insert($objet) {
        $requete = "INSERT INTO Attribution VALUES (:idEtab, :idTypeChambre, :idGroupe, :nbChambres)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function update($nbChambres, $objet) {
        $ok = false;
        $requete = "UPDATE  Attribution SET IDETAB=:idetab, IDTYPECHAMBRE=:idTypeChambre,
           IDGROUPE=:idGroupe, NBCHAMBRES=:nbChambres";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':nbChambres', $nbChambres);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function delete($nbChambres) {
        $ok = false;
        $requete = "DELETE FROM Attribution WHERE NBCHAMBRE = :nbChambres";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':nbChambres', $nbChambres);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    public static function getOneBynbChambres($nbChambres) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Attribution WHERE NBCHAMBRES = :nbChambres";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':nbChambres', $nbChambres);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    public static function getAllOfferingRooms() {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution 
                WHERE ID IN 
                   (SELECT DISTINCT ID
                    FROM Offre o
                    INNER JOIN Etablissement e ON e.ID = o.IDETAB
                    ORDER BY ID)";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }
    
    public static function isAnExistingnbChambres($nbChambres) {
        $requete = "SELECT COUNT(*) FROM Attribution WHERE NBCHAMBRES=:nbChambres";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':nbChambres', $nbChambres);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    
    public static function isAnExistingName($estModeCreation, $id, $nom) {
        $nom = str_replace("'", "''", $nom);
        // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
        // on vérifie la non existence d'un autre établissement (id!='$id') portant 
        // le même nom
        if ($estModeCreation) {
            $requete = "SELECT COUNT(*) FROM Attribution WHERE NBCHAMBRES=:nbChambres";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':nbChambres', $nbChambres);
            $stmt->execute();
        } else {
            $requete = "SELECT COUNT(*) FROM Attribution WHERE NBCHAMBRES=:nbChambres AND IDTYPECHAMBRE<>:idTypeChambre";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':nbChambres', $nbChambres);
            $stmt->bindParam(':idTypeChambre', $idTypeChambre);
            $stmt->execute();
        }
        return $stmt->fetchColumn(0);
    }
}
