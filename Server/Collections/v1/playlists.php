<?php

use Models\PlaylistData;
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
            $id = Request::$url[2] ?? null;

            // Check if we should get all songs of a playlist
            if (isset(Request::$url[3]) && Request::$url[3] == 'songs')
            {
                $songs = array();
                foreach (PlaylistData::readSongs($id) as $song)
                    $songs[] = array(
                        "type" => "song",
                        "id" => $song['songID'],
                        "attributes" => array(
                            "name"    => $song['name'],
                            "artist"  => $song['artist'],
                            "genreID" => $song['genreID'],
                        )
                    );
                // Send our data to the client
                Response::send_data($songs); // Also stops the code here
            }

            // Else just get the playlists
            $playlists = array();
            foreach (PlaylistData::read($id) as $list)
                if ($user['userID'] == $list['userID'] || $list['is_public'] == 1)
                    $playlists[] = array(
                        "type" => "playlist",
                        "id" => $list['listID'],
                        "attributes" => array(
                            "name"   => $list['name'],
                            "public" => $list['is_public'] == 1,
                            "owner"  => $list['userID']
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
        if(Permissions::has_permisions(Request::$auth->get_user()['permissions'], PERM_DELETE))
        {
            // Get our playlist id
            $id = Request::$url[2] ?? null;

            if (!isset($id))
                Response::send_error(404, "Not Found", "No id found!");
            // Check if we should remove a song from a playlist
            else if (isset(Request::$url[3]) && Request::$url[3] == 'songs')
                PlaylistData::deleteSong($id, Request::$url[4]);
            else
                PlaylistData::delete($id);
            Response::send(array(
                "status" => 200,
                "title" => "OK"
            ));
        }
    }
}
return new Playlists(); // Export the class