<?php

use Server\Permissions;
use Server\SQL;

/**
 * Collection handler
 */
class Playlists implements Collection
{
    public function POST()
    {

    }
    public function GET()
    {
        $user = Request::$auth->get_user();
        if(Permissions::has_permisions($user['permissions'], PERM_READ))
        {
            $query = "SELECT * FROM playlists";
            $id = Request::$url[2] ?? null;
            if ($id != null)
                $query .= " WHERE listID=$id";
            
            // Execute our query 
            $playlists = array();
            foreach (SQL::Execute($query)->fetchAll() as $list)
                if ($user['userID'] == $list['userID'] || $list['is_public'] == 1)
                    $playlists[] = array(
                        "type" => "genre",
                        "id" => $list['listID'],
                        "attributes" => array(
                            "name" => $list['name'],
                        )
                    );
            // Send our data to the client
            Response::send_data($playlists);
        }
        Response::send_error(403, "Forbidden", "Read permission required");
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
return new Playlists(); // Export the class