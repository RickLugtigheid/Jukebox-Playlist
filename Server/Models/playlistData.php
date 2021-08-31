<?php
namespace Models;

use IModel;
use Server\SQL;

class PlaylistData implements IModel
{
    /**
     * Finds a playlist
     * @param string $query Example: is_public=1
     */
    public static function find($query)
    {
        return SQL::Execute("SELECT * FROM playlists WHERE $query")->fetchAll();
    }
    /**
     * Creates a new playlist
     * @param array('name' => string, 'is_public' => bool, userID => int) $data
     */
    public static function create($data)
    {
        if (!isset($data['name']) || !isset($data['is_public']) || !isset($data['userID'])) return false;

        SQL::ExecutePrepare("INSERT INTO playlists (name, is_public, userID) VALUES (:name, :public, :user)", array(
            ":name"   => $data['name'],
            ":user"  => $data['userID'],
            ":public" => $data['is_public'] // Store as a bit 1(true) or 0(false)
        ));
        return true;
    }
    /**
     * Adds a song to the playlist
     */
    public static function createSong($listID, $songID)
    {
        SQL::ExecutePrepare("INSERT INTO saved_songs (listID, songID) VALUES (:list, :song)", array(
            ":list"   => $listID,
            ":song"  => $songID
        ));
        return true;
    }
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