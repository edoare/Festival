<?php 
/**
 * Contrôleur : gestion des offres d'hébergement
 */

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

use modele\dao\DaoOffre;
use modele\dao\Bdd;
use modele\metier\Offre;
use modele\dao\EtablissementDAO;
use modele\dao\TypeChambreDAO;

require_once __DIR__ . '/includes/autoload.php';
Bdd::connecter();

// 1ère étape (donc pas d'action choisie) : affichage du tableau des offres en 
// lecture seule
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape   
switch ($action) {
    case 'initial' :
        include("vues/OffreHebergement/vConsulterOffreHebergement.php");
        break;

    case 'demanderModifierOffre':
        $idEtab = $_REQUEST['idEtab'];
        include("vues/OffreHebergement/vModifierOffreHebergement.php");
        break;

    case 'validerModifierOffre':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $nbChambres = $_REQUEST['nbChambres'];
        $nbLignes = $_REQUEST['nbLignes'];
        $err = false;
        for ($i = 0; $i < $nbLignes; $i = $i + 1) {
            // Si la valeur saisie n'est pas numérique ou est inférieure aux 
            // attributions déjà effectuées pour cet établissement et ce type de
            // chambre, la modification n'est pas effectuée
            $entier = estEntier($nbChambres[$i]);
            $modifCorrecte = DaoOffre::estModifOffreCorrecte($idEtab, $idTypeChambre[$i], $nbChambres[$i]);
            if (!$entier || !$modifCorrecte) {
                $err = true;
            } else {
                $objet = new Offre(EtablissementDAO::getOneById($idEtab), TypeChambreDAO::getOneById($idTypeChambre[$i]), $nbChambres[$i]);
                $idObjet = array();
                $idObjet['Etab'] = $idEtab;
                $idObjet['TypeChambre'] = $idTypeChambre[$i];
                $ok = DaoOffre::isAnExistingId($idObjet);
                
                if($nbChambres[$i] != 0){
                    if($ok){
                        DaoOffre::update($idObjet, $objet);
                    } else {
                        DaoOffre::insert($objet);
                    }
                } else {
                    DaoOffre::delete($idObjet);
                }
            }
        }
        if ($err) {
            ajouterErreur(
                    "Valeurs non entières ou inférieures aux attributions effectuées");
            include("vues/OffreHebergement/vModifierOffreHebergement.php");
        } else {
            include("vues/OffreHebergement/vConsulterOffreHebergement.php");
        }
        break;
}

// Fermeture de la connexion au serveur MySql
$connexion = null;

