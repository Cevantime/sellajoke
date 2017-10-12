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
class UsersDAO extends DAO implements UserProviderInterface
{
    public function buildEntity(array $datas)
    {
        $user = new User();
        
        foreach (['username','salt','password','role', 'email', 'id'] as $field) {
            if (isset($datas[$field])) {
                $user->{'set'.ucfirst($field)}($datas[$field]);
            }
        }
        
        return $user;
    }

    public function loadUserByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE ';
                
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $sql .= 'email = ?';
        } else {
            $sql .= 'username = ?';
        }
        
        $userDatas = $this->db->fetchAssoc($sql, [$username]);
        
        if (! $userDatas) {
            throw new UsernameNotFoundException();
        }
        
        return $this->buildEntity($userDatas);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Entity\User';
    }
    
    public function insert(User $user)
    {
        /*
         * Dans cet exemple nous utilisons une requeête écrtie "à la main"
         * Pour voir un exemple de requeête écrite à l'aide du query builder,
         * se référer à la classe CategoryDAO ou à la classe JokeDAO
         */
        $datas = [];
        foreach (['username','password','role', 'email', 'salt'] as $field) {
            $fieldValue = $user->{'get'.ucfirst($field)}();
            if (! is_null($fieldValue)) {
                $datas[$field] = $fieldValue;
            }
        }
        
        $fieldsToInsert = array_keys($datas);
        
        $sql = 'INSERT INTO users ('.implode(',', $fieldsToInsert).') '
                . 'VALUES (:'.implode(', :', $fieldsToInsert).')' ;
        
        
        $this->db->executeQuery($sql, $datas);
        
        // on peut ajouter l'id à l'entité maintenant !
        
        $user->setId($this->db->lastInsertId());
    }
}
