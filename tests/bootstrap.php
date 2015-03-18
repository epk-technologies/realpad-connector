<?php
define("REALPAD_TEST_ENDPOINT", "https://dev.realpad.eu/ws/v10/");
define("REALPAD_TEST_CMS_LOGIN", 'xxx');
define("REALPAD_TEST_CMS_PASSWORD", 'yyy');

$base_path = dirname(__DIR__) . DIRECTORY_SEPARATOR;
spl_autoload_register(
    function($class_name) use($base_path)
    {
        if(!preg_match('~^RealPadConnector\\\\(.+)$~', $class_name, $m)){
            return false;
        }

        $file_path = $base_path . 'src' . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $m[1]) . '.php';
        if(file_exists($file_path)){
            /** @noinspection PhpIncludeInspection */
            require_once($file_path);
            return true;
        }

        return false;
    }
);
require_once($base_path . 'vendor/autoload.php');