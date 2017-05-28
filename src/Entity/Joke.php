<?php


namespace Entity;

/**
 * Description of Joke
 *
 * @author cevantime
 */
class Joke {
	
	/**
	 *
	 * @var integer
	 */
	private $id;
	
	/**
	 * 
	 * @var string
	 */
	private $title;
	
	/**
	 *
	 * @var string 
	 */
	private $text;
	
	/**
	 *
	 * @var string 
	 */
	private $image;
	
	/**
	 *
	 * @var Category 
	 */
	private $category;
	
	
	function getId() {
		return $this->id;
	}

	function getText() {
		return $this->text;
	}

	function getImage() {
		return $this->image;
	}

	function getCategory() {
		return $this->category;
	}
	
	function getTitle() {
		return $this->title;
	}
	
	function setId($id) {
		$this->id = $id;
	}

	function setText($text) {
		$this->text = $text;
	}

	function setImage($image) {
		$this->image = $image;
	}

	function setCategory(Category $category) {
		$this->category = $category;
	}
	
	function setTitle($title) {
		$this->title = $title;
	}



}
