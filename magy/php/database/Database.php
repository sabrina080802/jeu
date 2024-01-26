<?php

namespace Magy\Database;

use Magy\Utils\ArrayExtension;
use Magy\Utils\StringsHelper;

class Database
{
    private $pdo;
    private $name;

    public function __construct($host, $name, $user, $password, $options = [])
    {
        $this->name = $name;
        $this->pdo = new \PDO("mysql:host=" . $host . ';dbname=' . $name . ';default_charset=utf8mb4', $user, $password, $options);
    }
    public function first($request, $params = [])
    {
        $query = $this->pdo->prepare($request);
        $this->bindParams($request, $query, $params);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    public function query($request, $params = [])
    {
        $query = $this->pdo->prepare($request);
        $this->bindParams($request, $query, $params);
        $query->execute();
        return new ArrayExtension($query->fetchAll(\PDO::FETCH_ASSOC));
    }

    private function bindParams($request, $query, $params)
    {
        foreach ($params as $key => $value) {
            if (strpos($request, ":$key") !== false) {
                $query->bindValue(":$key", $value);
            }
        }
    }
    public function configure($schemaDb)
    {
        $tables = $schemaDb->query('SELECT * FROM TABLES WHERE TABLE_SCHEMA = :name', ['name' => $this->name]);
        $columns = $schemaDb->query('SELECT * FROM COLUMNS WHERE TABLE_SCHEMA = :name', ['name' => $this->name]);

        $model = file_get_contents(__DIR__ . '/DbModel.php');
        $serviceModel = file_get_contents(__DIR__ . '/ServiceModel.php');

        for ($i = 0; $i < $tables->count(); $i++) {
            $t = $tables[$i];
            $tableColumns = new ArrayExtension();

            for ($j = 0; $j < $columns->count(); $j++) {
                if ($columns[$j]['TABLE_NAME'] == $t['TABLE_NAME']) {
                    $tableColumns->push($columns[$j]);
                }
            }

            $data = [];
            $this->createTable($t, $tableColumns, $model, $data);
            $this->createService($t, $tableColumns, $serviceModel, $data);
        }
    }
    private function createService($tableInfos, $columns, $phpServiceModel, $data)
    {
        $path = PRIVATE_APP_PATH . 'services/' . $data['EntityName'] . 'Service.php';
        //if(!file_exists($path)){
        foreach ($data as $key => $value) {
            $phpServiceModel = preg_replace('/\{\{' . $key . '}\}/', $value, $phpServiceModel);
        }
        file_put_contents($path, $phpServiceModel);
        return;
        //}


    }
    private function createTable($tableInfos, $columns, $phpEntityModel, &$data)
    {
        $entityName = StringsHelper::toCamelCase($tableInfos['TABLE_NAME']);

        $props = '';
        $propsFillObj = '';
        $propsCtor = '';
        $propsFillCtor = '';
        $protectedPropsFillObj = '';
        $queryPropsFillCtor = '';
        $insertReqFillObj = '';
        $primaryKeysCondition = '';
        for ($i = 0; $i < $columns->count(); $i++) {
            $colName = StringsHelper::toCamelCase($columns[$i]['COLUMN_NAME']);
            $colName = strtolower($colName[0]) . substr($colName, 1);
            $props .= "\tpublic \$$colName;" . PHP_EOL;
            $propsFillObj .= "\t\t\$this->$colName = \$$colName;" . PHP_EOL;
            if ($i > 0) {
                $propsCtor .= ', ';
                $queryPropsFillCtor .= ',';
                $protectedPropsFillObj .= ', ';
            }
            $propsCtor .= "\$$colName=null";
            $queryPropsFillCtor .= ":$colName";
            $protectedPropsFillObj .= $columns[$i]['COLUMN_NAME'];
            $insertReqFillObj .= "\t\t\t\"$colName\" => \$$colName";
            if ($i < $columns->count() - 1) {
                $insertReqFillObj .= ',';
            }
            $insertReqFillObj .= PHP_EOL;
        }

        $data['EntityName'] =  $entityName;
        $data['TableName'] =  $tableInfos['TABLE_NAME'];
        $data['DbName'] =  $this->name;
        $data['Properties'] =  $props;
        $data['PropsFillObj'] =  $propsFillObj;
        $data['PropertiesCtor'] =  $propsCtor;
        $data['PropsFillCtor'] =  $propsFillCtor;
        $data['ProtectedPropsFillObj'] =  $protectedPropsFillObj;
        $data['QueryPropsFillCtor'] =  $queryPropsFillCtor;
        $data['InsertReqFillObj'] =  $insertReqFillObj;
        $data['PrimaryKeysCondition'] = $primaryKeysCondition;

        foreach ($data as $key => $value) {
            $phpEntityModel = preg_replace('/\{\{' . $key . '}\}/', $value, $phpEntityModel);
        }
        file_put_contents(PRIVATE_APP_PATH . 'entity/' . $entityName . '.php', $phpEntityModel);
    }
}
