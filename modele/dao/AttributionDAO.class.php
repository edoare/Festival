<?php

namespace modele\dao;

use modele\metier\Attribution;
use PDO;

/**
 * Description of AttributionDAO
 * Classe métier : Attribution
 * @author btssio
 */
class AttributionDao implements IDAO {

    protected static function enregVersMetier($enreg) {
        $idOffre= array();$idOffre['Etab']=$enreg['IDETAB'];
        $idOffre['TypeChambre']=$enreg['IDTYPECHAMBRE'];        
        $offre = DaoOffre::getOneById($idOffre);
        $groupe = GroupeDAO::getOneById($enreg['IDGROUPE']);
        $nombreChambres = $enreg['NOMBRECHAMBRES'];
         
        $unAttrib = new Attribution($offre,$groupe,$nombreChambres );

        return $unAttrib;
    }

    /**
     * Valorise les paramètre d'une requête préparée avec l'état d'un objet Attribution
     * @param type $objetMetier une Attribution
     * @param type $stmt requête préparée
     */
    
    protected static function metierVersEnreg($objetMetier, $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        $stmt->bindValue(':idEtab', $objetMetier->getOffre()->getEtab()->getId());
        $stmt->bindValue(':idTypeChambre', $objetMetier->getOffre()->getTypeChambre()->getId());
        $stmt->bindValue(':idGroupe', $objetMetier->getGroupe()->getId());
        $stmt->bindValue(':nombreChambres', $objetMetier->getNombreChambres());
    }
    
public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Attribution WHERE IDETAB = :idEtab AND IDTYPECHAMBRE= :idTypeChambre AND IDGROUPE= :idGroupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $id['Offre']['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['Offre']['TypeChambre']);
        $stmt->bindParam(':idGroupe', $id['Groupe']);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }
    /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Attribution $objet objet métier à insérer
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function insert($objet) {
        $requete = "INSERT INTO Attribution VALUES (:idEtab, :idTypeChambre, :idGroupe, :nombreChambres)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param string identifiant de l'enregistrement à mettre à jour
     * @param Attribution $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, $objet) {
        $ok = false;
        $requete = "UPDATE  Attribution SET NOMBRECHAMBRES= :nombreChambres 
           WHERE IDETAB=:idEtab AND IDTYPECHAMBRE=:idTypeChambre AND IDGROUPE=:idGroupe";
      
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idEtab', $id['Offre']['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['Offre']['TypeChambre']);
        $stmt->bindParam(':idGroupe', $id['Groupe']);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM Attribution WHERE IDETAB = :idEtab
        AND IDTYPECHAMBRE= :idTypeChambre
        AND IDGROUPE= :idGroupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $id['Offre']['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['Offre']['TypeChambre']);
        $stmt->bindParam(':idGroupe', $id['Groupe']);
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

        /**
     * Permet de vérifier s'il existe ou non un établissement ayant déjà le même identifiant dans la BD
     * @param string $id identifiant de l'établissement à tester
     * @return boolean =true si l'id existe déjà, =false sinon
     */
    public static function isAnExistingId($id) {
        $requete = "SELECT COUNT(*) FROM Attribution WHERE IDETAB = :idEtab
        AND IDTYPECHAMBRE= :idTypeChambre
        AND IDGROUPE= :idGroupe";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $id['Offre']['Etab']);
        $stmt->bindParam(':idTypeChambre', $id['Offre']['TypeChambre']);
        $stmt->bindParam(':idGroupe', $id['Groupe']);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
 
    public static function obtenirNbDispo($idEtab, $idTypeChambre) {
        $nbOffre = DaoOffre::obtenirNbOffre($idEtab, $idTypeChambre);
        if ($nbOffre != 0) {
            // Recherche du nombre de chambres occupées pour l'établissement et le
            // type de chambre en question
            $nbOccup = self::obtenirNbOccup($idEtab, $idTypeChambre);
            // Calcul du nombre de chambres libres
            $nbChLib = $nbOffre - $nbOccup;
            return $nbChLib;
        } else {
            return 0;
        }
    }
    
    public static function obtenirNbOccup($idEtab, $idTypeChambre) {
        $requete = "SELECT IFNULL(SUM(nombreChambres), 0) AS totalChambresOccup FROM
            Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        return $nb;
    }
    
    public static function obtenirNbOccupGroupe($idEtab, $idTypeChambre, $idGroupe) {
        $req = "SELECT nombreChambres FROM Attribution 
                WHERE idEtab=:idEtab 
                  AND idTypeChambre=:idTypeCh 
                  AND idGroupe=:idGroupe";

        $stmt = Bdd::getPdo()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->execute();
        $ok = $stmt->fetchColumn();
        if ($ok) {
            return $ok;
        } else {
            return 0;
        }
    }
    
    // Teste la présence d'attributions pour le type de chambre transmis 
    public static function existeAttributionsTypeChambre($id) {
        $req = "SELECT COUNT(*) FROM Attribution WHERE idTypeChambre=?";
        $stmt = Bdd::getPdo()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }
    
    // Teste la présence d'attributions pour l'établissement transmis    
    public static function existeAttributionsEtab($id) {
        $req = "SELECT COUNT(*) FROM Attribution WHERE idEtab=?";
        $stmt = Bdd::getPdo()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }
   
}
