<!DOCTYPE html>
<html> <head> 
        <meta charset="UTF-8"> 
        <title>Offre Test</title> 
    </head> 
    <body> 
        <?php

        use modele\metier\Offre;
        use modele\metier\Etablissement;
        use modele\metier\TypeChambre;
        require_once __DIR__ . '/../includes/autoload.php';
        
        echo "<h2>Test unitaire de la classe métier Offre</h2>";
        $etab = new Etablissement('0350799A', 'Collège Ste Jeanne d\'Arc-Choisy', '3, avenue de la Borderie BP 32', '35404', 'Paramé', '0299560159', NULL, '1', 'Madame', 'LEFORT', 'ANNE');
        $typeChambre = new TypeChambre('C2', '2 à 3 lits');
        $objet = new Offre($etab, $typeChambre, '8');
        var_dump($objet);
        ?> 
    </body> 
</html>