<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Attribution</title>
    </head>
    <body>
        <?php
        use modele\metier\Attribution;
        use modele\metier\TypeChambre;
        use modele\metier\Groupe;
        use modele\metier\Etablissement;
        
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test Attribution</h2>";
        
        $typeChambre = new TypeChambre("C1", "1 lit");
        $groupe = new Groupe("G015", "La Tuque Bleue", NULL, NULL, 8, "Québec", "O");
        $etab = new Etablissement("0352072M", "Institution Saint-Malo Providence", "2 rue du collège BP 31863", "35418", "Saint-Malo", "0299407474", NULL, 1, "Monsieur", "Durand", "Pierre");
        $attribution = new Attribution($etab,$typeChambre,$groupe, 15);        
        
        var_dump($attribution);
        ?>
    </body>
</html>
