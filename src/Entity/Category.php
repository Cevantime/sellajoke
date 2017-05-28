<?php


namespace Entity;

/**
 * Description of Category
 *
 * @author cevantime
 */
class Category {
	
	/**
	 * 
	 * @var integer 
	 */
	private $id;
	
	/**
	 * 
	 * @var string
	 */
	private $name; 
	
	/**
	 *
	 * @var string
	 */
	private $icon;
	
	function getId() {
		return $this->id;
	}

	function getName() {
		return $this->name;
	}

	function getIcon() {
		return $this->icon;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setName($name) {
		$this->name = $name;
	}

	function setIcon(varchar $icon) {
		$this->icon = $icon;
	}


}
