<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TestDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\EtablissementDAO;
        use modele\dao\PDO;

require_once __DIR__ . '/../includes/autoload.php';

        $id = 'g021';
        Bdd::connecter();

        echo "<h2>Test OffreDAO</h2>";

        // Test n°1
        echo "<h3>Test getOneById</h3>";
        try {
            $objet = GroupeDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>Test getAll</h3>";
        try {
            $lesObjetsO = OffreDAO::getAll();
            var_dump($lesObjetsO);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>Test getAllToHost</h3>";
        try {
            $lesObjetsO = OffreDAO::getAllToHost();
            var_dump($lesObjetsO);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        Bdd::deconnecter();
        ?>


    </body>
</html>
