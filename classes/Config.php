<?php

class Config {

    public static function get($path = null) {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            //Loop until you find what youre looking for in the init.php config array
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            //Return the value of the index you were looking for
            return $config;
        }
        //if no path is given then return false
        return false;
    }

}
