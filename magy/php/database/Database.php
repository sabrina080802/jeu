<?php namespace Magy\Database;

use Magy\Utils\ArrayExtension;

class Database{
    private $pdo;
    private $name;

    public function __construct($host, $name, $user, $password, $options=[]){
        $this->name = $name;
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
        return new ArrayExtension($query->fetchAll(\PDO::FETCH_ASSOC));
    }

    private function bindParams($request, $query, $params){
        foreach($params as $key => $value){
            if(strpos($request, ":$key") !== false){
                $query->bindValue(":$key", $value);
            }
        }
    }
    public function configure($schemaDb){
        $tables = $schemaDb->query('SELECT * FROM TABLES WHERE TABLE_SCHEMA = :name', ['name' => $this->name]);
        $model = file_get_contents('DbModel.php');
        for($i = 0;$i < $tables->count();$i++){
            $this->createTable($tables[$i], $model);
        }
    }
    private function createTable($tableInfos, $phpEntityModel){
        $dictionaryVars = [
            'TableName' => $tableInfos['TABLE_NAME'],
            'DbName' => $this->name,
            'Properties' => '',
            'PropsFillObj' => '',
            'PropertiesCtor' => '',
            'ProtectedPropsFillObj' => '',
            'QueryPropsFillCtor' => ''
        ];

        for($dictionaryVars as $key => $value){
            //$phpEntityModel = preg_replace('')
        }
    }
}

?>