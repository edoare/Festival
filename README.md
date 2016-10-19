Projet Festival (Festival Folklores du Monde de Saint Malo) en Php pour le module de PPE 2SLAM à La Joliverie (2016-2017)
- Version initiale distribuée aux étudiants pour démarrer le projet.
- Les scripts de création de la base de données MySql sont dans un sour-répertoire sql.
- Le projet est architecturé "façon MVC", mais pas de façon stricte : les vues contiennent des traitements
- Le projet est en phase de "ré-usinage" afin de créer une couche modèle orientée objet, avec des classes métier et des classes DAO ; 
il reste à compléter cette couche en ajoutant les classes nécessaires pour gérer les Offres d'hébergement ainsi que les attributions
d'offres aux groupes, et les classes DAO associées ; il faudra également intégrer l'usage de ces classes aux contrôleurs et aux vues, 
en remplacement des fonctions classiques actuellement regroupées dans le répertoire "includes/gestionDonnees"
