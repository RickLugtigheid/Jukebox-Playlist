<?php
// [Server Headers]
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// [Global Variables]
define("LOG_SETTINGS", array(
    "max_size" => 64,
    "level" => "all"
));
define("TOKEN_EXPIRE", "+30 minutes");