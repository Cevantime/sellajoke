<?php


namespace Entity;

/**
 * Description of Category
 *
 * @author cevantime
 */
class Category
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
    private $name;
    
    /**
     *
     * @var string
     */
    private $icon;
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setIcon(varchar $icon)
    {
        $this->icon = $icon;
    }
}
