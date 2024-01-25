<?php namespace Magy\Managers;

use Magy\Database\Database;

class DbManager{
    private static $databases = [];

    //connexion a la bdd
    //self = this mais pour les statics 
    public static function getDatabase($name){
        if(isset(self::$databases[$name]) == false){
            include CONFIG_PATH . 'Databases/' . $name . '.php';
        }

        return self::$databases[$name];
    }
    public static function createDatabase($host, $name, $user, $password, $options=[]){
        if(isset(self::$databases[$name])){
            return;
        }

        $db = new Database($host, $name, $user, $password, $options);
        self::$databases[$name] = $db;
    }
}

?>