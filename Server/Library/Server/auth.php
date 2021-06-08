<?php
namespace Server;

use Firebase\JWT;
use Response;

class Auth
{
    /**
     * The decoded jwt
     */
    private $decoded;
    /**
     * If the decoded key is valid
     */
    public $is_valid = false;

    public $user;

    public function __construct($jwt)
    {
        if(isset($jwt) && $jwt !== "")
        {
            // Decode the jwt
            $base64 = base64_decode($jwt);
            $this->decoded = (array)JWT::decode($base64, Auth::get_key(), array('HS256'));
        }
    }
    public function validate()
    {
        // Check if we have a decoded key
        if(!isset($this->decoded))
            return false; // So we just continue without a valid key        
        // Else the token is valid!
        $this->is_valid = true;

        // Get the user that authenticated with this token
        $this->user = SQL::Execute("SELECT * FROM users WHERE userID=" . $this->get_data()['id'])->fetch();
    }
    /**
     * Returns the data of our jwt
     * @return array
     */
    public function get_data()
    {
        if($this->is_valid)
            return (array)$this->decoded['data'];
        Response::send_error(403, "Forbidden", "Invalid key given");
        exit();
    }
    /**
     * Get the key for this server
     */
    public static function get_key()
    {
        // We use php_uname and $_SERVER['HTTP_HOST'] to make a server unique key
        return sha1($_SERVER['SERVER_SOFTWARE'] . '-' . $_SERVER['HTTP_HOST'] . "@" . php_uname());
    }
}