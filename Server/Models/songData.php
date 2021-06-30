<?php
namespace Models;

use IModel;
use Server\SQL;

class SongData implements IModel
{
    /**
     * Finds a song
     * @param string $query Example: name=songName
     */
    public static function find($query)
    {
        return SQL::Execute("SELECT * FROM songs WHERE $query")->fetchAll();
    }
    /**
     * Creates a new song
     * @param array('name' => string, 'genreID' => int) $data
     */
    public static function create($data)
    {
        if (!isset($data['name']) || !isset($data['genreID'])) return false;

        SQL::ExecutePrepare("INSERT INTO songs (name, genreID) VALUES (:name, :genre)", array(
            ":name"  => $data['name'],
            ":genre" => $data['genreID'],
        ));

        return true;
    }
    /**
     * Reads all songs or the song with id
     */
    public static function read($id = null)
    {
        $query = "SELECT * FROM songs ";
        if (isset($id) && $id !== '') $query .= "WHERE songID=$id";
        return SQL::Execute($query)->fetchAll();
    }
    public static function update($data)
    {

    }
    public static function delete($id)
    {
        SQL::Execute("DELETE FROM songs WHERE songID=$id");
        return true;
    }
}