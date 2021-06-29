<?php

use Models\SongData;
use Server\Permissions;

/**
 * Collection handler
 */
class Songs implements Collection
{
    public function POST()
    {

    }
    public function GET()
    {
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_READ))
        {
            $id  = Request::$url[2] ?? null;
            $songs = array();
            foreach (SongData::read($id) as $song)
                $songs[] = array(
                    "type" => "song",
                    "id" => $song['songID'],
                    "attributes" => array(
                        "name"    => $song['name'],
                        "artist"  => $song['artist'],
                        "genreID" => $song['genreID'],
                    )
                );
        }
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
return new Songs(); // Export the class