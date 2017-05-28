<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DAO;

use Entity\Category;

/**
 * Description of CategoryDAO
 *
 * @author cevantime
 */
class CategoriesDAO extends DAO {
	
	public function buildEntity(array $datas) {
		
		$category = new Category();
        
        foreach(array('name', 'id') as $field) {
            if(isset($datas[$field])){
                $category->{'set'.ucfirst($field)}($datas[$field]);
            }
        }
        
        return $category;
	}
	
	public function insert(Category $category) {
		
		// on utilise ici le query builder de doctrine DBAL
		
		$this->db->insert('categories', array(
			'name' => $category->getName(),
			'icon' => $category->getIcon()
		));
		
		$category->setId($this->db->lastInsertId());
	}
	
	public function update(Category $category) {
		
		// on utilise ici le query builder de doctrine DBAL
		$data = array(
			'name' => $category->getName()
		);
		
		if($category->getIcon()) {
			$data['icon'] = $category->getIcon();
		}
		
		$this->db->update('categories', $data, array('id'=>$category->getId()));
		
	}
	
	public function save(Category $category) {
		if($category->getId()) {
			$this->update($category);
		} else {
			$this->insert($category);
		}
	}


	public function find($id) {
		$datas = $this->db->fetchAssoc('SELECT * FROM categories WHERE id = ?', array($id));
		if($datas) {
			return $this->buildEntity($datas);
		}
		return null;
			
	}
	
	public function findByName($name) {
		$datas = $this->db->fetchAssoc('SELECT * FROM categories WHERE name = ?', array($name));
		if($datas) {
			return $this->buildEntity($datas);
		}
		return null;
	}

}
