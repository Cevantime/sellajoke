<?php

namespace DAO;

use Entity\Joke;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Description of JokesDAO
 *
 * @author cevantime
 */
class JokesDAO extends DAO {
	
	public function buildEntity(array $datas) {
		
		$joke = new Joke();
        
        foreach(array('text', 'title', 'id') as $field) {
            if(isset($datas[$field])){
                $joke->{'set'.ucfirst($field)}($datas[$field]);
            }
        }
		
		/*
		 * le traitement est un peu particulier pour l'image qui doit être une 
		 * instance de Symfony\Component\HttpFoundation\File\File 
		 * (cf https://symfony.com/doc/current/controller/upload_file.html)
		 */
		
		global $app;
		
		if(isset($datas['image'])) {
			$joke->setImage(new File('uploads/jokes/'.$datas['image']));
		}
		
		// on tente maintenant de retrouver la caétégorie associée à cette blague
		
		// on inclut d'abord la variable $app pour pouvoir récupérer le dao des catégories
		
		
		$categoryDao = $app['dao.categories'];
		
		/*
		 * deux cas se présentent : 
		 *  -	soit les données associées à la catégorie sont
		 *		déjà présentes dans $datas (si on a fait une requête joignant les 
		 *		blagues et leur catégorie par exemple). Au quel cas, on tente
		 *		de reconstruire l'entité directement à partir de ces données
		 *  -	soit seul l'id de l'entité est présente, dans ce cas, on utilise 
		 *		le dao de l'entité pour aller chercher l'entité correspondante
		 */
		
		/*
		 * On considère que si le colonne category_name est présente, il doit y
		 * avoir d'autres données associées à la catégorie dans $datas
		 */
		if( ! empty($datas['category_name'])) {
			/*
			 * On reconstitue le tableau de données de la catégorie en partant 
			 * de la convention selon laquelle les données sont présentes dans 
			 * $datas sous le nom 'category_{NOM_DU_CHAMP}'. Cette convention 
			 * doit donc être respectée dans le reste du site
			 */
			$catDatas = array();
			foreach(array('icon', 'name','id') as $fieldCat) {
				if( !empty($datas['category_'.$fieldCat])) {
					$catDatas[$fieldCat] = $datas['category_'.$fieldCat];
				}
			}
			
			/*
			 * Une fois les données de la catégorie récupérées, on peut 
			 * contruire l'entité à l'aide du DAO
			 */
			
			$category = $categoryDao->buildEntity($catDatas);
			
		} else {
			// sinon, charger la catégorie grâce au dao des catégories
			$category = $categoryDao->find($datas['category_id']);
			
		}
		
		if($category) {
			$joke->setCategory($category);
		}
        
        return $joke;
	}
	
	/**
	 * Récupère les dernières entrées de la table, éventuellement filtrées par une
	 * clause where sous la forme d'un tableau associatif et/ou par des limites 
	 * ATTENTION, la table categories doit être mentionnées sous l'alias 'c' dans
	 * le where.
	 * 
	 * EX : si $where == array ( 'title = ?' => 'Toto', 'c.name = ?' => 'dark') 
	 * alors la requête sera :
	 * 
	 * SELECT *, categories.name as category_name
	 * FROM jokes 
	 * INNER JOIN categories c ON c.id = jokes.category_id
	 * WHERE title = 'Toto' AND c.name = 'dark'
	 * 
	 * @param array $where
	 * @param type $limit
	 * @param type $offset
	 */
	public function findLast(array $where = array(), $limit = null, $offset = null) {
		$db = $this->db->createQueryBuilder();
		
		/*
		 * On utilise ici le query builder de $db qui permet d'écrire des requêtes SQL
		 * à l'aide de fonctions PHP
		 */
		$query = $db->select('*, c.name as category_name')
			->from('jokes', 'j');
		
		// Ici $query ressemble à SELECT * FROM jokes as j
		
		// On fait la jointure sur les catégories
		
		$query->innerJoin('j', 'categories', 'c', 'j.category_id = c.id');
		
		/* 
		 * Ici $query ressemble à :
		 * SELECT * FROM jokes as j 
		 * INNER JOIN categories as c ON j.category.id = c.id
		 */
		
		// si une clause $where a été passée en paramètre sous la forme d'un tableau
		
		if($where) {
			/*
			 * on récupère les clés de notre tableau where qui sont en fait les 
			 * colonnes à filtrer (title = ?)
			 */
			$params = array();
			foreach($where as $column => $value) {
				if( ! $params) {
					$query->where($column);
				} else {
					$query->andWhere($column);
				}
				$params[] = $value;
			}
		}
		
		/*
		 * si where est non nul, $query ressemble à 
		 * SELECT * FROM jokes as j 
		 * INNER JOIN categories as c ON j.category.id = c.id
		 * WHERE title = 'Toto' AND category_name = 'dark'
		 */
		
		$query->orderBy('j.id', 'DESC');
		
		if($limit && $offset) {
			$query->setFirstResult($limit);
			$query->setMaxResults($offset);
		} else if($limit) {
			$query->setMaxResults($limit);
		}
		
		/*
		 * si limit est non nul, $query ressemble à 
		 * SELECT * FROM jokes as j 
		 * INNER JOIN categories as c ON j.category_id = c.id
		 * WHERE title = 'Toto' AND category_name = 'dark'
		 * ORDER BY id DESC
		 * LIMIT 5,10
		 */
		
		/*
		 * Enfin, on exécute la requête et on récupère les résultats sous la 
		 * sous la forme d'entités
		 */
		
		$datas = $this->db->fetchAll($query->getSQL(), empty($params) ? array() : $params);
		
		$rows = array();
		
		foreach($datas as $data) {
			$rows[$data['id']] = $this->buildEntity($data);
		} 
		
		return $rows;
		
	}


	public function insert(Joke $joke) {
		
		// on utilise ici le query builder de doctrine DBAL
		
		// on commence par regénérer le tableau de données en utilisant les getters
		
		$this->db->insert('jokes', array(
			'title'			=> $joke->getTitle(),
			'image'			=> $joke->getImage()->getFileName(),
			'text'			=> $joke->getText(),
			'category_id'	=> $joke->getCategory()->getId()
		));
		
		$joke->setId($this->db->lastInsertId());
	}
	
	public function update(Joke $joke) {
		$datas = array();
		foreach (array('title', 'image') as $basicField) {
			$datas[$basicField] = $joke->{'get'.ucfirst($basicField)}();
		}
		
		if($joke->getImage()) {
			$data['image'] = $joke->getImage()->getFileName();
		}
		
		$data['category_id'] = $joke->getCategory()->getId();
		
		$this->db->update('jokes', $data, array('id'=>$joke->getId()));
	}

	public function save(Joke $joke) {
		if($joke->getId()) {
			$this->update($joke);
		} else {
			$this->insert($joke);
		}
	}


	public function find($id) {
		$datas = $this->db->fetchAssoc('SELECT *, categories.name as category_name '
				. 'FROM jokes '
				. 'INNER JOIN categories ON categories.id = jokes.category_id '
				. 'WHERE jokes.id = ?', array($id));
		if($datas) {
			return $this->buildEntity($datas);
		}
		return null;
			
	}
}
