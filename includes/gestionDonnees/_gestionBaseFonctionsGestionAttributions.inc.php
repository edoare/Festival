<?php

// FONCTIONS UTILISÉES UNIQUEMENT DANS LA GESTION DES ATTRIBUTIONS
// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab, à l'id type chambre et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idTypeChambre, $idGroupe, $nbChambres) {
    $req = "SELECT COUNT(*) AS nombreAttribGroupe 
        FROM Attribution 
        WHERE idEtab= :idEtab AND idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
    $stmt = $connexion->prepare($req);
    $stmt->bindParam(':idEtab', $idEtab);
    $stmt->bindParam(':idTypeCh', $idTypeChambre);
    $stmt->bindParam(':idGroupe', $idGroupe);
    $stmt->execute();
    $lgAttrib = $stmt->fetchColumn();
    if ($nbChambres == 0) {
        $req = "DELETE FROM Attribution WHERE idEtab=:idEtab AND 
           idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
        $stmt = $connexion->prepare($req);
    } else {
        if ($lgAttrib != 0) {
            $req = "UPDATE Attribution SET nombreChambres=:nbCh 
                WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh 
                AND idGroupe=:idGroupe";
        } else {
            $req = "INSERT INTO Attribution VALUES(:idEtab, :idTypeCh, :idGroupe, :nbCh)";
        }
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':nbCh', $nbChambres);
    }
    $stmt->bindParam(':idEtab', $idEtab);
    $stmt->bindParam(':idTypeCh', $idTypeChambre);
    $stmt->bindParam(':idGroupe', $idGroupe);

    $ok = $stmt->execute();
    return $ok;
}

// Retourne le nombre de chambres libres pour l'établissement et le type de
// chambre en question (retournera 0 si absence d'offre ou si absence de 
// disponibilité)  
function obtenirNbDispo($connexion, $idEtab, $idTypeChambre) {
    $nbOffre = obtenirNbOffre($connexion, $idEtab, $idTypeChambre);
    if ($nbOffre != 0) {
        // Recherche du nombre de chambres occupées pour l'établissement et le
        // type de chambre en question
        $nbOccup = obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
        // Calcul du nombre de chambres libres
        $nbChLib = $nbOffre - $nbOccup;
        return $nbChLib;
    } else {
        return 0;
    }
}

// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id type chambre transmis
function obtenirNbOccupGroupe($connexion, $idEtab, $idTypeChambre, $idGroupe) {
//    global $connexion;
    $req = "SELECT nombreChambres FROM Attribution 
            WHERE idEtab=:idEtab 
              AND idTypeChambre=:idTypeCh 
              AND idGroupe=:idGroupe";

    $stmt = $connexion->prepare($req);
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
