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
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_CREATE))
        {
            $name = $_POST['name'];

            SQL::ExecutePrepare("INSERT INTO genres (name) VALUES (:name)", array(
                ":name" => $name
            ));
            Response::send_error(200, "OK", "User Created");
        }
        Response::send_error(403, "Forbidden", "Create permission required");
    }
    public function GET()
    {
        // Check if we have a user with read permissions
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_READ))
        {
            $id   = Request::$url[2] ?? null;
            // Check if we should get songs by id or not
            $query = "SELECT * FROM genres";
            if ($id != null)
                $query .= " WHERE genreID=$id";

            // Execute our query
            $genres = array();
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