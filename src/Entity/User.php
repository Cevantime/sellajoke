<?php

namespace Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of User
 *
 * @author Formateur
 */
class User implements UserInterface
{
   
    
    /**
     *
     * @var integer $id
     */
    public $id;
    
    /**
     *
     * @var string[] roles
     */
    public $role;
    
    /**
     *
     * @var string password
     */
    public $password;
    
    /**
     *
     * @var string username
     */
    public $username;
    
    /**
     *
     * @var string email
     */
    public $email;
    
    /**
     *
     * @var $salt
     */
    public $salt;
    
    public function eraseCredentials()
    {
        $this->password = '';
    }
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function getRoles()
    {
        return [$this->role];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setRole($roles)
    {
        $this->role = $roles;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getSalt()
    {
        return $this->salt;
    }
    
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
