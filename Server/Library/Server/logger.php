<?php
namespace Server;

use ZipArchive;

class Logger
{
    public static function WriteLine($line, $file)
    {
        $path = ROOT . "/Logs/$file.log";
        $date_now = date("Y-m-d H:i:s");

        // Check if we should rotate the log file
        // If we should we zip the file and clear it
        if(file_exists($path) && round(filesize($path) / 1024) >= LOG_SETTINGS['max_size'])
        {
            // Create new zip class
            $zip = new ZipArchive();
            // Create a zip and add the log file
            if ($zip->open(ROOT . "/logs/$file.log-" . date("Y-m-d H.i.s") . ".zip", ZipArchive::CREATE) === TRUE)
            {
                $zip->addFile($path, "$file.log");
                $zip->close();

                // Clear the log file
                file_put_contents($path, "");
            }
        }

        // Write the line in the correct log file
        file_put_contents($path, "[$date_now]: $line\n", FILE_APPEND);
    }
}