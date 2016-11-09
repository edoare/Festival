<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>AttributionDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\AttributionDAO;
        use modele\dao\Bdd;
        use modele\metier\Attribution;

require_once __DIR__ . '/../includes/autoload.php';

        $nbChambres = 21;
        Bdd::connecter();

        echo "<h2>1- AttributionDAO</h2>";

        // Test n°1
        echo "<h3>Test getOneByNbChambres</h3>";
        try {
            $objet = AttributionDAO::getOneBynbChambres($nbChambres);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = AttributionDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id = '9999999A';
            $objet = new Attribution('0483167P', 'C4', 'g008', $nbChambres);
            $ok = AttributionDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = AttributionDAO::getOneBynbChambres($nbChambres);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°3-bis
        echo "<h3>3- insert déjà présent</h3>";
        try {
            $id = '9999999A';
            $objet = new Attribution('0483167P', 'C4', 'g008', $nbChambres);
            $ok = AttributionDAO::insert($objet);
            if ($ok) {
                echo "<h4>*** échec du test : l'insertion ne devrait pas réussir  ***</h4>";
                $objetLu = Bdd::getOneBynbChambres($nbChambres);
                var_dump($objetLu);
            } else {
                echo "<h4>ooo réussite du test : l'insertion a logiquement échoué ooo</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $e->getMessage();
        }

        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet->setidTypeChambre('C5');
            $objet->setidGroupe('g009');
            $ok = AttributionDAO::update($nbChambres, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = AttributionDAO::getOneBynbChambres($nbChambres);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = AttributionDAO::delete($nbChambres);
//            $ok = EtablissementDAO::delete("xxx");
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°6
        echo "<h3>6- getAllOfferingRooms</h3>";
        try {
            $lesObjets = AttributionDAO::getAllOfferingRooms();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°7
        echo "<h3>7- isAnExistingnbChambres</h3>";
        try {
            $id = 21;
            $ok = AttributionDAO::isAnnbChambres($nbChambres);
            $ok = $ok && !AttributionDAO::isAnExistingnbChambres(30);
            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°8
        echo "<h3>7- isAnExistingName</h3>";
        try {
            // id et nom d'un établissement existant
            $id = "0350785N";
            $nom = "Collège de Moka";
            $ok=true;
            // en mode modification (1er paramètre = false)
            $ok = EtablissementDAO::isAnExistingName(false, "0123456", $nom);
            $ok = $ok && !EtablissementDAO::isAnExistingName(false, $id, $nom);
            // en mode création (1er paramètre = true)
            $ok = $ok && EtablissementDAO::isAnExistingName(true, "0123456", $nom);
            $ok = $ok && !EtablissementDAO::isAnExistingName(true, "0123456", "Ecole");
            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        Bdd::deconnecter();
        ?>


    </body>
</html>

