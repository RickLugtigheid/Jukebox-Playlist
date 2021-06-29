<?php

use Models\UserData;
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
            
            // Create a new user
            if (UserData::create(array('username' => $username, 'password' => $password, 'permissions' => $perms)))
                Response::send_error(200, "OK", "User Created");
            // Else return an error
            Response::send_error(500, "Internal server error", "Couldn't create user '$username'");
        }
        Response::send_error(403, "Forbidden", "Create permission required");
    }
    public function GET()
    {
        $users = array();
        foreach (UserData::read() as $user)
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
            UserData::delete($_POST['uid'] ?? null);
            Response::send_error(200, "OK", "User Deleted");
        }
        Response::send_error(403, "Forbidden", "Delete permission required");
    }
}
return new Users(); // Export the class