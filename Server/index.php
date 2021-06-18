<?php
// [Configure the server]

use Server\Logger;

define('ROOT', __DIR__);
require_once ROOT . '/Config/server.php';

// Register library autoload
spl_autoload_register(function ($class)
{
    $path = "./library/$class.php";
    if (file_exists($path))
        require($path);
    else
        throw new Error("Could not load lib '$path'");
});
// Catch all errors
set_error_handler(function ($errno, $errstr, $errfile, $errline)
{
    // Log the error in the server logs
    Logger::WriteLine("\nError($errno) $errstr\n    at: $errfile line $errline\n", "error");
    // Return internal server error
    Response::send_error(500, "Internal Server Error", "There was an error in the server code.");
});
set_exception_handler(function ($error)
{
    // Log the error in the server logs
    Logger::WriteLine("\n$error\n", "error");

    // Return internal server error
    Response::send_error(500, "Internal Server Error", "There was an uncaught exception in the server code.");
});

// [Handle request]
// Set request variables
Request::$url = array_slice(explode('/', $_SERVER['REQUEST_URI']), 1);
Request::$method = $_SERVER['REQUEST_METHOD'];
Request::$auth = new Server\Auth(apache_request_headers()['Authorization'] ?? null);
Request::$auth->validate();

// Sanitize POST and GET data to prevent XSS 
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

// Start handling the request
if (Request::$method == "OPTIONS") return;
Request::handle(); 

// [Server Classes]
/**
 * @static
 */
class Request
{
    /**
     * The request url as array
     * @var array
     */
    public static $url;
    /**
     * The request method; POST, GET, ...
     * @var string
     */
    public static $method;
    /**
     * The version of the api we want to use; v1, v2
     * @var string
     */
    public static $version;
    /**
     * The collection being called
     * @var string
     */
    public static $collection;
    /**
     * Authentication object
     * @var Server\Auth
     */
    public static $auth;

    public static function handle()
    {
        Request::$version = Request::$url[0];
        // Check if a version was given in the url        
        if (Request::$version === '') Response::send_error(404, "Not Found", "No version given");
        // Check if our url has more than 1 variable; so /v1/...
        if (count(Request::$url) > 1) Request::$collection = Request::$url[1];
        else Response::send_error(404, "Not Found", "No collection given");

        // Check if the collection exists
        $collection_path = ROOT . '/Collections/' . Request::$version . '/' . Request::$collection . '.php';
        if(file_exists($collection_path))
        {
            $collection_class = require_once $collection_path;
            // Call the correct method on the object
            $method = Request::$method;
            $collection_class->$method();
            // If no response was given in collection we give a response here
            Response::send_error(405, "Method Not Allowed", "No response for method " . Request::$method . " on collection " . Request::$collection);
        }
        else Response::send_error(404, "Not Found", "There is no collection named '" . Request::$collection . "' for version '" . Request::$version . "'");
    }
}
/**
 * @static
 */
class Response
{
    public static $status = 200; // Default: OK
    /**
     * Sets our response to an error
     * @param int $status Http error code
     * @param string $title Error title. Like 'Not Found'
     * @param string $details Error details
     */
    public static function send_error($status, $title, $details)
    {
        // Set http response code with error code
        Response::$status = $status;
        Response::send(array(
            "status" => $status,
            "title" => $title,
            "details" => $details
        ));
    }
    /**
     * Sets our response to an object with our given data
     * @param array $data
     */
    public static function send_data($data)
    {
        // Set http response code to 200 for OK
        Response::$status = 200;
        Response::send(array(
            "meta" => array(
                "total" => count($data)
            ), 
            "data" => $data
        ));
    }
    public static function send($response)
    {
        // Set response code
        http_response_code(Response::$status);
        // Send the data
        echo json_encode($response);
        // Check if we should log this request/response
        if (LOG_SETTINGS['level'] == 'all') Logger::WriteLine($_SERVER['REMOTE_ADDR'] . " [" . Response::$status . "]: " . Request::$method . " " . $_SERVER['REQUEST_URI'], "request");
        // Stop futher code from running
        exit();
    }
}
interface Collection
{
    public function POST();
    public function GET();
    public function PUT();
    public function PATCH();
    public function DELETE();
}