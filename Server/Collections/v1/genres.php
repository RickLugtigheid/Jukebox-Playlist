<?php

use Server\Auth;
use Server\Permissions;
use Server\SQL;

/**
 * Collection handler
 */
class Genres implements Collection
{
    public function POST()
    {

    }
    public function GET()
    {
        // Check if we have a user with read permissions
        if(Permissions::has_permisions(Request::$auth->user['permissions'], PERM_READ))
        {
            $search   = URI[1] ?? "";
            // Check if we should get songs by id or not
            $query = "SELECT * FROM genres";
            if ($search != '')
                $query .= " WHERE genreID=" . $search;
            $genres = array();

            // Execute our query
            foreach (SQL::Execute($query)->fetchAll() as $genre)
                $genres[] = array(
                    "type" => "genre",
                    "id" => $genre['genreID'],
                    "attributes" => array(
                        "name" => $genre['name'],
                    )
                );
            
            // Send our data to the client 
            Response::send_data($genres);
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
return new Genres(); // Export the class