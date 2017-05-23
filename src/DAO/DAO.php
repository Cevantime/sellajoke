<?php

namespace DAO;

/**
 * Description of DAO
 *
 * @author Formateur
 */
abstract class DAO {
    
    /**
     * Une instance de la connexion à la bdd par défaut
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * var array datas données bdd sous la forme d'un tableau associatif
	 * 
	 * @return une entité
     */
    public abstract function buildEntity(array $datas);
	
}
