<?php
namespace Server;
use PDO;
use PDOException;
use Response;

class SQL
{
    private static function CreateConnection($server_conn = false){
        try
        {
            // Create a PDO connection to the database
            $conn = null;
            $config = parse_ini_file(ROOT . "/Config/sql.ini");
            if($server_conn) $conn = new PDO("mysql:host=". $config["host"], $config["user"], $config["password"]);
            else $conn = new PDO("mysql:host=". $config["host"] .";dbname=". $config["database"], $config["user"], $config["password"]);
            
            //the first Attribute will report it to the webpage if something goes wrong
            //the second trows the error to the catch 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     
            return $conn;
        }
        catch(PDOException $e)
        {
            Logger::WriteLine("\n$e\n", "error");
            Response::send_error(503, "Service Unavailable", "No connection to the database could be made");
        }
    }
    /**
     * @param string $query
     * @return PDOStatement Query Result 
     */
    public static function Execute($query, $on_database=true){
        $conn = SQL::CreateConnection(!$on_database);
        if(is_array($conn)) return $conn;
        return $conn->query($query);
    }
    /**
     * @param string $query
     * @param array $prepare_args
     * @return PDOStatement Query Result 
     */
    public static function ExecutePrepare($query, $prepare_args){
        $conn = SQL::CreateConnection();
        $stmt = $conn->prepare($query);
        
        //bind params
        foreach($prepare_args as $key => &$value) 
        {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();
    }
    /**
     * @param string $path
     * @return PDOStatement Query Result 
     */
    public static function ExecuteFile($path){
        $conn = SQL::CreateConnection();

        $query = file_get_contents($path);
        
        return $conn->exec($query);
    }
    /**
     * @param string $path
     * @param array $prepare_args
     * @return PDOStatement Query Result 
     */
    public static function ExecutePrepareFile($path, $prepare_args){
        return SQL::ExecutePrepare(file_get_contents($path), $prepare_args);
    }
}