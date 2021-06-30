<?php
namespace Models;

use IModel;
use Server\SQL;

class UserData implements IModel
{
    /**
     * Finds a song
     * @param string $query Example: username=username123
     */
    public static function find($query)
    {
        return SQL::Execute("SELECT * FROM users WHERE $query")->fetchAll();
    }
    /**
     * Creates a new user
     * @param array('username' => string, 'password' => string, 'permissions' => string) $data
     */
    public static function create($data)
    {
        if (!isset($data['username']) || !isset($data['password'])) return false;

        SQL::ExecutePrepare("INSERT INTO users (username, password, permissions) VALUES (:username, :password, :permissions)", array(
            ":username"     => $data['username'],
            ":password"     => password_hash($data['password'], PASSWORD_BCRYPT),
            ":permissions"  => $data['permissions']
        ));

        return true;
    }
    /**
     * Reads all users or the user with id
     */
    public static function read($id = null)
    {
        $query = "SELECT * FROM users ";
        if (isset($id) && $id !== '') $query .= "WHERE userID=$id";
        return SQL::Execute($query)->fetchAll();
    }
    public static function update($data)
    {

    }
    public static function delete($id)
    {
        SQL::Execute("DELETE FROM user WHERE userID=$id");
        return true;
    }
}