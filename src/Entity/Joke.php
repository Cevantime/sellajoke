<?php


namespace Entity;

/**
 * Description of Joke
 *
 * @author cevantime
 */
class Joke
{
    
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
    
    
    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getCategory()
    {
        return $this->category;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
