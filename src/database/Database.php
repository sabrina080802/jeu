<?php namespace Magy\Database;

class Database{
    private $pdo;

    public function __construct($host, $name, $user, $password, $options=[]){
        $this->pdo = new \PDO("mysql:host=" . $host .';dbname=' . $name .';default_charset=utf8mb4', $user, $password, $options);
    }
    public function first($request, $params=[]){
        foreach ($params as $key => $value) {
            $request = str_replace('@' . $key, $value, $request);
        }

        return (object)$this->pdo->query($request)->fetch(\PDO::FETCH_ASSOC);
    }
    public function query($request, $params=[]){
        foreach($params as $key => $value){
            $request = str_replace('@' . $key, $value, $request);
        }

        return $this->pdo->query($request)->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>