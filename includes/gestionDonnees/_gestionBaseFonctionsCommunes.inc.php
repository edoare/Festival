<?php

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS
// Désormais intégrées aux DAO

// FONCTIONS DE GESTION DES TYPES DE CHAMBRES
// Désormais intégrées aux DAO

// FONCTIONS RELATIVES AUX GROUPES
// Désormais intégrées aux DAO

// FONCTIONS RELATIVES AUX OFFRES
// Met à jour (suppression, modification ou ajout) l'offre correspondant à l'id
// étab et à l'id type chambre transmis
function modifierOffreHebergement($connexion, $idEtab, $idTypeChambre, $nbChambresDemandees) {
    if ($nbChambresDemandees == 0) {
        $req = "DELETE FROM Offre WHERE idEtab=:idEtab and idTypeChambre=
           :idTypeCh";
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
    } else {
        $req2 = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND 
        idTypeChambre=:idTypeCh";
        $stmt2 = $connexion->prepare($req2);
        $stmt2->bindParam(':idEtab', $idEtab);
        $stmt2->bindParam(':idTypeCh', $idTypeChambre);
        $stmt2->execute();
        $lgOffre = $stmt2->fetchColumn();
        if ($lgOffre != 0) {
            $req = "UPDATE Offre SET nombreChambres=:nb 
                WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        } else {
            $req = "INSERT INTO Offre VALUES(:idEtab, :idTypeCh, :nb)";
        }
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':nb', $nbChambresDemandees);
    }
    $ok = $stmt->execute();
    return $ok;
}

// Retourne le nombre de chambres offertes pour l'id étab et l'id type chambre 
// transmis
function obtenirNbOffre($connexion, $idEtab, $idTypeChambre) {
    $req = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND 
        idTypeChambre=:idTypeCh";
    $stmt = $connexion->prepare($req);
    $stmt->bindParam(':idEtab', $idEtab);
    $stmt->bindParam(':idTypeCh', $idTypeChambre);
    $stmt->execute();
    $ok = $stmt->fetchColumn();
    if ($ok) {
        return $ok;
    } else {
        return 0;
    }
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement et le type de chambre transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $idTypeChambre, $nombreChambres) {
    $nbOccup = obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
    return ($nombreChambres >= $nbOccup);
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS
// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id) {
    $req = "SELECT COUNT(*) FROM Attribution WHERE idEtab=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}

// Teste la présence d'attributions pour le type de chambre transmis 
function existeAttributionsTypeChambre($connexion, $id) {
    $req = "SELECT COUNT(*) FROM Attribution WHERE idTypeChambre=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}

// Retourne le nombre de chambres occupées pour l'id étab et l'id type chambre
// transmis
function obtenirNbOccup($connexion, $idEtab, $idTypeChambre) {
    $req = "SELECT IFNULL(SUM(nombreChambres), 0) AS totalChambresOccup FROM
        Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
    $stmt = $connexion->prepare($req);
    $stmt->bindParam(':idEtab', $idEtab);
    $stmt->bindParam(':idTypeCh', $idTypeChambre);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    return $nb;
}
