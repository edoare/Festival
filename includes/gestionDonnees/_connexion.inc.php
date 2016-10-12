<?php

//// Pour compatibilité avec anciennes méthodes d'accès aux BD
//error_reporting(E_ALL ^ E_DEPRECATED);

$hote = "localhost";
$login = "festival";
$mdp = "secret";
$bd = "festival";
$dsn = "mysql:host=$hote;dbname=$bd";
$connexion = null;
/**
 * Crée un objet de type PDO et ouvre la connexion 
 * @return un objet de type PDO pour accéder à la base de données
 */
/* Connexion à une base via PDO */
try {
    $connexion = new PDO($dsn, $login, $mdp);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->query("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    ajouterErreur("Echec de la connexion au serveur MySQL");
    ajouterErreur(" => " . $e->getMessage());
}
 