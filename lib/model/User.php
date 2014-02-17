<?php

/**
 * User model class
 * @class User
 */
class User extends Model
{
    public $id;
    public $username;
    public $password;

    /**
     * Get all users
     * @param Database $con
     * @return User[]
     */
    public static function find(Database $con = null)
    {
        $con = (!$con) ? Database::getConnection(Database::DEFAULT_SETTING) : $con;
        $stmt = $con->run('SELECT * FROM user');
        return $stmt->fetchAll(Database::FETCH_CLASS, __CLASS__);
    }

    /**
     * Find user by id
     * @param $id
     * @param Database $con
     * @return User
     */
    public static function findById($id, Database $con = null)
    {
        $con = (!$con) ? Database::getConnection(Database::DEFAULT_SETTING) : $con;
        $stmt = $con->run(
            'SELECT * FROM user WHERE id = ?',
            array($id)
        );

        $user = $stmt->fetchObject(__CLASS__);
        return (!$user) ? null : $user;
    }

    /**
     * Validation function
     */
    public function validate()
    {
        $this->id = (int)$this->id;
        if (!$this->username || !$this->password) {
            throw new Exception('Username/Password cannot be empty');
        }
        $this->password = md5($this->password);
    }

    /**
     * Insert new user
     * @param Database $con
     * @return int [Affected rows]
     */
    public function insert(Database $con = null)
    {
        $this->validate();

        $con = (!$con) ? Database::getConnection(Database::DEFAULT_SETTING) : $con;
        $stmt = $con->run(
            'INSERT INTO user(username, password) VALUES (?, ?)',
            array($this->username, md5($this->password))
        );
        $this->id = $con->lastInsertId('id');
        return $stmt->rowCount();
    }
}