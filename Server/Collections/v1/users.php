<?php

use Server\Auth;
use Server\Permissions;
use Server\SQL;

/**
 * Collection handler
 */
class Users implements Collection
{
    public function POST()
    {
        // Check if we have a user with create permissions
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_CREATE))
        {
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $perms      = Permissions::parse($_POST['permissions']);

            SQL::ExecutePrepare("INSERT INTO users (username, password, permissions) VALUES (:username, :password, :permissions)", array(
                ":username"     => $username,
                ":password"     => password_hash($password, PASSWORD_BCRYPT),
                ":permissions"  => $perms
            ));
            Response::send_error(200, "OK", "User Created");
        }
        Response::send_error(403, "Forbidden", "Create permission required");
    }
    public function GET()
    {
        $users = array();
        foreach (SQL::Execute("SELECT * FROM Users")->fetchAll() as $user)
        {
            $users[] = array(
                "type" => "user",
                "id" => $user['userID'],
                "attributes" => array(
                    "name" => $user['username'],
                )
            );
        }
        Response::send_data($users);
    }
    public function PUT()
    {
        
    }
    public function PATCH()
    {
        
    }
    public function DELETE()
    {
        // Check if we have a user with create permissions
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_DELETE))
        {
            $id = $_POST['uid'] ?? null;
            SQL::Execute("DELETE FROM Users WHERE userID=$id");
            Response::send_error(200, "OK", "User Deleted");
        }
        Response::send_error(403, "Forbidden", "Delete permission required");
    }
}
return new Users(); // Export the class