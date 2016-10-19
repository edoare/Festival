<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>EtablissementDAO : test</title>
    </head>

    <body>

        <?php

        use modele\metier\Offre;
        use modele\metier\Etablissement;
        use modele\metier\TypeChambre;

require_once __DIR__ . '/../includes/autoload.php';
        echo "TestOffre";
        $etab = new Etablissement('0123456A', 'Collège St Pierre ', '3, avenue de la Borderie BP 32', '35404', 'Paramé', '0299560159', NULL, '1', 'Madame', 'Truc', 'Muche');
        $typeChambre = new typeChambre('C7', '2 à 4 lits');
        $objet = new Offre($etab, $typeChambre, '8');
        var_dump($objet);
        ?> 
    </body>
</html>
