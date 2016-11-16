<?php

include("includes/_gestionErreurs.inc.php");
//include("includes/gestionDonnees/_connexion.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");
//include("includes/gestionDonnees/_gestionBaseFonctionsGestionAttributions.inc.php");

use modele\dao\AttributionDAO;
use modele\metier\Attribution;
use modele\dao\DaoOffre;
use modele\dao\GroupeDAO;
use modele\dao\Bdd;

require_once __DIR__ . '/includes/autoload.php';
Bdd::connecter();

// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// attributions en lecture seule
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        include("vues/AttributionChambres/vConsulterAttributionChambres.php");
        break;

    case 'demanderModifierAttrib':
        include("vues/AttributionChambres/vModifierAttributionChambres.php");
        break;

    case 'donnerNbChambres':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $idGroupe = $_REQUEST['idGroupe'];
        $nbChambres = $_REQUEST['nbChambres'];
        include("vues/AttributionChambres/vDonnerNbChambresAttributionChambres.php");
        break;

    case 'validerModifierAttrib':
        $id = array();
        $id['Offre']['Etab'] = $_REQUEST['idEtab'];
        $id['Offre']['TypeChambre'] = $_REQUEST['idTypeChambre'];
        $id['Groupe'] = $_REQUEST['idGroupe'];
        $nbChambres = $_REQUEST['nbChambres'];
        $uneOffre = DaoOffre::getOneById($id['Offre']);
        $uneAttribution= new Attribution ($uneOffre,GroupeDAO::getOneById($id['Groupe']),$nbChambres);
        $ok = AttributionDAO::isAnExistingId($id);
        
        if($nbChambres != 0){
            if($ok){
                AttributionDAO::update($id, $uneAttribution);
            } else {
                AttributionDAO::insert($uneAttribution);
            }
        } else {
            AttributionDAO::delete($id);
        }
        include("vues/AttributionChambres/vModifierAttributionChambres.php");
        break;
}

// Fermeture de la connexion au serveur MySql
$connexion = null;


