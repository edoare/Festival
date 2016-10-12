<?php

namespace modele\dao;

/**
 * Description of DAO
 * Interface pour les classes de type DAO
 * Une classe DAO permet la liaison entre le modèle objet et le modèle relationnel de la BDD
 * @author btssio
 */
interface IDAO {


    /**
     * Construire un objet d'après son identifiant, à partir des des enregistrements de la table visée
     * @param id identifiant de l'enregistrement dans la table correspondante
     * @return objet métier si trouvé dans la BDD, null sinon
     * Une Exception doit être déclenchée en cas d'erreur PDO
     */
    public static function getOneById($id) ;

    /**
     * Construire une collection (tableau associatif) d'objets à partir des enregistrements de la table visée
     * @return une collection (tableau associatif) d'objets métier ; elle peut être vide
     * Une Exception doit être déclenchée en cas d'erreur PDO
     */
    public static function getAll();
    
    /**
     * Détruire un enregistrement de la table visée d'après son identifiant
     * @param identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     * Une Exception doit être déclenchée en cas d'erreur PDO
     */
    public static function delete($id) ;
    
    /**
     * Insérer un nouvel enregistrement dans la table visée à partir de l'état d'un objet métier
     * @param $objet objet métier à insérer
     * @return boolean =TRUE si l'enregistrement est créé,  =FALSE si l'opération échoue
     * Une Exception doit être déclenchée en cas d'erreur PDO
     */
    public static function insert($objet) ;
    
    /**
     * Mettre à jour enregistrement dans la table visée à partir de l'état d'un objet métier
     * @param identifiant de l'enregistrement à mettre à jour
     * @param $objet objet métier à mettre à jour
     * @return boolean =TRUE si l'enregistrement est mis à jour,  =FALSE si l'opération échoue
     * Une Exception doit être déclenchée en cas d'erreur PDO
     */
    public static function update($id, $objet) ;
    
}
