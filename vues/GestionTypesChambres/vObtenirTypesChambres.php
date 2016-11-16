<?php
use modele\dao\TypeChambreDAO;
use modele\dao\AttributionDAO;
use modele\dao\Bdd;
require_once __DIR__ . '/../../includes/autoload.php';

include("includes/_debut.inc.php");

// AFFICHER L'ENSEMBLE DES TYPES DE CHAMBRES 
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR 
// TYPE DE CHAMBRE

echo "
<br>
<table width='40%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Types de chambres</strong></td>
   </tr>";
$lesTypesChambres = TypeChambreDAO::getAll();


// BOUCLE SUR LES TYPES DE CHAMBRES
foreach ($lesTypesChambres as $unTypeChambre) {
    $id = $unTypeChambre->getId();
    $libelle = $unTypeChambre->getLibelle();
    echo "
      <tr class='ligneTabNonQuad'> 
         <td width='15%'>$id</td>
         <td width='33%'>$libelle</td>
         <td width='26%' align='center'>
         
         <a href='cGestionTypesChambres.php?action=demanderModifierTypeChambre&id=$id'>
         <button type=button>Modifier</button></a></td>";

    // S'il existe déjà des attributions pour le type de chambre, il faudra
    // d'abord les supprimer avant de pouvoir supprimer le type de chambre
    if (!AttributionDAO::existeAttributionsTypeChambre($id)) {
        echo "
            <td width='26%' align='center'>
            <a href='cGestionTypesChambres.php?action=demanderSupprimerTypeChambre&id=$id'>
            <button type=button>Supprimer</button></a></td>";
    } else {
        echo "<td width='26%'>&nbsp; </td>";
    }
    echo "               
    </tr>";
}
echo "    
</table><br>
<a href='cGestionTypesChambres.php?action=demanderCreerTypeChambre'>
<button type=button>Création d'un type de chambre</button></a>";

include("includes/_fin.inc.php");

