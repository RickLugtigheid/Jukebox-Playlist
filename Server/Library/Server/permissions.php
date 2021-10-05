<?php
namespace Server;
// Binary permision values
define("PERM_CREATE",   0b0001);
define("PERM_READ",     0b0010);
define("PERM_UPDATE",   0b0100);
define("PERM_DELETE",   0b1000);
define("PERM_ALL",      0b1111);
class Permissions
{
    public static function has_permisions($user_permisions, $has_permisions)
    {
        // If we get perms from the database we get a binary string and need to convert that to int
        $user_permisions = bindec($user_permisions); 

        // Check if the user has permisions using bitwise and opperator
        return decbin($has_permisions) == (decbin($user_permisions) & decbin($has_permisions));

        // [Bitwise And]:
        // The AND opperator returns a 1 if there is a 1 in both numbers on the same place else it returns a 0
        // Example:
        //   1001 # user perms
        //   0001 # has perms
        // & ====
        //   0001
    }
    public static function parse($perms)
    {
        if(is_numeric($perms)) return $perms > 4 ? 4 : $perms;
        else
        {
            $perm_int = 0;
            foreach (explode(',', $perms) as $type)
            {
                switch(strtoupper($type))
                {
                    case "CREATE":
                        $perm_int += PERM_CREATE;
                        break;
                    case "READ":
                        $perm_int += PERM_READ;
                        break;
                    case "UPDATE":
                        $perm_int += PERM_UPDATE;
                        break;
                    case "DELETE":
                        $perm_int += PERM_DELETE;
                        break;
                }
            }
            return decbin($perm_int);
        }
    }
}