<?php

namespace modele\dao;

use modele\metier\Groupe;
use PDO;

/**
 * Description of GroupeDAO
 * Classe métier :  Groupe
 * @author btssio
 */
class GroupeDAO implements IDAO {


    protected static function enregVersMetier($enreg) {
        $id = $enreg['ID'];
        $nom = $enreg['NOM'];
        $identite = $enreg['IDENTITERESPONSABLE'];
        $adresse = $enreg['ADRESSEPOSTALE'];
        $nbPers = $enreg['NOMBREPERSONNES'];
        $nomPays = $enreg['NOMPAYS'];
        $hebergement = $enreg['HEBERGEMENT'];
        $unGroupe = new Groupe($id, $nom, $identite, $adresse, $nbPers, $nomPays, $hebergement);

        return $unGroupe;
    }


    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Groupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Groupe WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    public static function insert($objet) {
        return false;
    }

    public static function update($id, $objet) {
        return false;
    }
    
    public static function delete($id) {
        return false;
    }

    /**
     * Retourne la liste des groupes d'un établissement donné
     * @param string $idEtab
     * @return array
     */
    public static function getAllByEtablissement($idEtab) {
        $lesGroupes = array();
        $requete = "SELECT * FROM Groupe
                    WHERE ID IN (
                    SELECT DISTINCT ID FROM Groupe g
                            INNER JOIN Attribution a ON a.IDGROUPE = g.ID 
                            WHERE IDETAB=:id
                    )";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $idEtab);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesGroupes[] = self::enregVersMetier($enreg);
            }
        } 
        return $lesGroupes;
    }

    
    /**
     * Retourne la liste des groupes souhaitant un hébergement
     * @return array liste des groupes souhaitant un hébergement, ordonnée par id
     */
    public static function getAllToHost() {
        $lesGroupes = array();
        $requete = "SELECT * FROM Groupe WHERE HEBERGEMENT='O' ORDER BY ID";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesGroupes[] = self::enregVersMetier($enreg);
            }
        }
        return $lesGroupes;
    }

}
