<?php

namespace Entity;

use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of User
 *
 * @author Formateur
 */
class User implements UserInterface {
   
    
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
	
    public function eraseCredentials() {
        $this->password = '';
    }
    
    function getRole() {
        return $this->role;
    }
    
    function getRoles() {
        return array($this->role);
    }

    function getPassword() {
        return $this->password;
    }

    function getUsername() {
        return $this->username;
    }

    function setRole($roles) {
        $this->role = $roles;
    }

    function setPassword($password) {
        $this->password = $password;
    }
	
	function getSalt() {
		return null;
	}

    function setUsername($username) {
        $this->username = $username;
    }

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

}
