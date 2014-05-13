<?php

/**
 * Class UserUtil
 */
class UserUtil
{
    /**
     * Create new username and password
     * @param $username
     * @param $password
     * @param Database $con
     * @return User
     */
    public static function create($username, $password, Database $con = null)
    {
        $con = (!$con) ? Database::getConnection(Database::DEFAULT_SETTING) : $con;
        $user = new User();
        $user->username = $username;
        $user->password = $password;
        $user->insert($con);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @param Database $con
     */
    public static function delete($id, Database $con)
    {
        $con = (!$con) ? Database::getConnection(Database::DEFAULT_SETTING) : $con;
        $con->run('DELETE FROM user WHERE id = ?', array($id));
    }

    /**
     * Update user by id
     * @param $id
     * @param $username
     * @param $password
     * @param Database $con
     */
    public static function update($id, $username, $password, Database $con = null)
    {
        $con = (!$con) ? Database::getConnection(Database::DEFAULT_SETTING) : $con;
        $con->run(
            'UPDATE user SET username = ?, password = ? WHERE id = ?',
            array($username, md5($password), $id)
        );
    }
}