<?php

namespace DAO;

use \Symfony\Component\Security\Core\User\UserProviderInterface;
use \Symfony\Component\Security\Core\User\UserInterface;
use \Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Entity\User;

/**
 * Description of UsersDAO
 *
 * @author Formateur
 */
class UsersDAO extends DAO implements UserProviderInterface {
    
    public function buildEntity(array $datas) {
        $user = new User();
        
        foreach(array('username','salt','password','role', 'email', 'id') as $field) {
            if(isset($datas[$field])){
                $user->{'set'.ucfirst($field)}($datas[$field]);
            }
        }
        
        return $user;
    }

    public function loadUserByUsername($username) {
        
        $sql = 'SELECT * FROM users WHERE ';
                
        if(filter_var($username, FILTER_VALIDATE_EMAIL)){
            $sql .= 'email = ?';
        } else {
            $sql .= 'username = ?';
        }
        
        $userDatas = $this->db->fetchAssoc($sql, array($username));
        
        if( ! $userDatas) {
            throw new UsernameNotFoundException();
        }
        
        return $this->buildEntity($userDatas);
        
    }

    public function refreshUser(UserInterface $user) {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'Entity\User';
    }
    
    public function insert(User $user) {
		$datas = array();
        foreach(array('username','password','role', 'email') as $field) {
			$fieldValue = $user->{'get'.ucfirst($field)}();
			if($fieldValue) {
				$datas[$field] = $fieldValue;
			}
		}
		
		$fieldsToInsert = array_keys($datas);
		
		$sql = 'INSERT INTO users ('.implode(',', $fieldsToInsert).') '
				. 'VALUES (:'.implode(', :', $fieldsToInsert).')' ;
		
		
		$this->db->executeQuery($sql, $datas);
    }


}
