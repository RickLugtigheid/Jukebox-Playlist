<?php
namespace Models;

use IModel;
use Server\SQL;

class GenreData implements IModel
{
    /**
     * Finds a genre
     * @param string $query Example: name=pop
     */
    public static function find($query)
    {
        return SQL::Execute("SELECT * FROM genres WHERE $query")->fetchAll();
    }
    /**
     * Creates a new genre
     * @param array('name' => string) $data
     */
    public static function create($data)
    {
        if (!isset($data['name'])) return false;

        SQL::ExecutePrepare("INSERT INTO genres (name) VALUES (:name)", array(
            ":name"  => $data['name'],
        ));

        return true;
    }
    /**
     * Reads all genres or the genre with id
     */
    public static function read($id = null)
    {
        $query = "SELECT * FROM genres ";
        if (isset($id) && $id !== '') $query .= "WHERE genreID=$id";
        return SQL::Execute($query)->fetchAll();
    }
    /**
     * Reads all the songs connected to a genre
     */
    public static function readSongs($genreID)
    {
        return SongData::find("genreID=$genreID");
    }
    public static function update($data)
    {

    }
    /**
     * Deletes the genre with id
     */
    public static function delete($id)
    {
        SQL::Execute("DELETE FROM genres WHERE genreID=$id");
        return true;
    }
}