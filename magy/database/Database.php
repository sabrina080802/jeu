<?php namespace Magy\Database;

class Database{
    private $pdo;

    public function __construct($host, $name, $user, $password, $options=[]){
        $this->pdo = new \PDO("mysql:host=" . $host .';dbname=' . $name .';default_charset=utf8mb4', $user, $password, $options);
    }
    public function first($request, $params=[]){
        $query = $this->pdo->prepare($request);
        $this->bindParams($request, $query, $params);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    public function query($request, $params=[]){
        $query = $this->pdo->prepare($request);
        $this->bindParams($request, $query, $params);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function bindParams($request, $query, $params){
        foreach($params as $key => $value){
            if(strpos($request, ":$key") !== false){
                $query->bindValue(":$key", $value);
            }
        }
    }
}

?>