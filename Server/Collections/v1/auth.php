<?php

use Firebase\JWT;
use Server\SQL;

/**
 * Collection handler
 */
class Auth implements Collection
{
    public function POST()
    {
        $id = $_POST['uid'] ?? null;
        $passwd = $_POST['password'] ?? null;

        // Check if we have this data in post
        if(!isset($id) || !isset($passwd)) Response::send_error(404, "Not Found", "Could not find 'id' and or 'password' in POST data");

        // Get the user with this id
        $user = SQL::Execute("SELECT * FROM Users WHERE userID=$id")->fetch();
        
        // Check if user exists
        if(!isset($user) || !is_array($user) || !isset($user['password'])) Response::send_error(404, "Not Found", "Could not find user with id '$id'");
          
        // Check if we have logedin as user
        if(password_verify($passwd, $user['password']))
        {
            // Create a new jwt
            $issued_at = strtotime("now");
            $expires_at = strtotime(TOKEN_EXPIRE);
    
            $payload = array(
                "iss" => $_SERVER['HTTP_HOST'], // Server host
                "iat" => $issued_at, // When token was created
                "exp" => $expires_at, // When the token expires
                "htc" => $_SERVER['REMOTE_ADDR'] . '@' . $_SERVER["HTTP_USER_AGENT"], // The http client that requested the token
                // Data so we can use this user when doing an action
                "data" => array(
                    "id" => (int)$user['userID'],
                    "username" => $user['username'],
                )
            );
            // Send a ok response with the token
            Response::send(array(
                "status" => 200,
                "title" => "OK",
                "token" => JWT::encode($payload, Server\Auth::get_key())
            ));
        }
        Response::send_error(406, "Not Acceptable", "Incorrect password for user with id '$id'");
    }
    public function GET()
    {
        if(!Request::$auth->is_valid)
            Response::send_error(403, "Forbidden", "Invalid key given");
        Response::send(array(
            "status" => 200,
            "title" => "OK",
        ));
    }
    public function PUT()
    {
        
    }
    public function PATCH()
    {
        
    }
    public function DELETE()
    {
        
    }
}
return new Auth(); // Export the class