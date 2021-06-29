<?php
namespace Models;
use Server\SQL;

class PlaylistData
{
    /**
     * Finds a playlist
     * @param string $query Example: is_public=1
     */
    public static function find($query)
    {
        return SQL::Execute("SELECT * FROM playlists WHERE $query")->fetchAll();
    }
    /*public static function create($data)
    {
        if (!isset($data['name']) || !isset($data['genreID'])) return false;

        SQL::ExecutePrepare("INSERT INTO songs (name, genreID) VALUES (:name, :genre)", array(
            ":name"  => $data['name'],
            ":genre" => $data['genreID'],
        ));

        return true;
    }*/
    /**
     * Reads all playlists or the playlist with id
     */
    public static function read($id = null)
    {
        $query = "SELECT * FROM playlists ";
        if (isset($id) && $id !== '') $query .= "WHERE listID=$id";
        return SQL::Execute($query)->fetchAll();
    }
    /**
     * Reads all songs connected to a playlist
     */
    public static function readSongs($listID)
    {
        $songs = array();
        foreach (SQL::Execute("SELECT * FROM saved_songs WHERE listID=$listID") as $saved_song)
            $songs[] = SongData::read($saved_song['songID'])[0];
        return $songs;
    }
    public static function update($data)
    {

    }
    public static function delete($id)
    {
        SQL::Execute("DELETE FROM playlists WHERE listID=$id");
    }
    public static function deleteSong($listID, $songID)
    {
        SQL::Execute("DELETE FROM saved_songs WHERE listID=$listID AND songID=$songID");
    }
}