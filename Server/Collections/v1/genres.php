<?php

use Models\GenreData;
use Server\Permissions;

/**
 * Collection handler
 */
class Genres implements ICollection
{
    public function POST()
    {
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_CREATE))
        {
            $name = $_POST['name'];

            GenreData::create(array(
                "name" => $name
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
            $id = Request::$url[2] ?? null;

            // Check if we should get all songs of a genre
            if (isset(Request::$url[3]) && Request::$url[3] == 'songs')
            {
                $songs = array();
                foreach (GenreData::readSongs($id) as $song)
                    $songs[] = array(
                        "type" => "song",
                        "id" => $song['songID'],
                        "attributes" => array(
                            "name"     => $song['name'],
                            "artist"   => $song['artist'],
                            "duration" => $song['duration'],
                            "genreID"  => $song['genreID']
                        )
                    );
                // Send our data to the client
                Response::send_data($songs); // Also stops the code here so we don't need to use else
            }
            // Else we just get all the genres
            $genres = array();
            foreach (GenreData::read(Request::$url[2] ?? null) as $genre)
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