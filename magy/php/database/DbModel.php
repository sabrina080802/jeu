<?php App\Entity\{{TableName}};

class {{TableName}}{
    {{Properties}}

    public function __construct({{PropertiesCtor}}){
        {{PropsFillObj}}
    }
    public static function create({{PropertiesCtor}}){
        $entity = new {{TableName}}({{PropsFillCtor}});
        $db = DbManager::getDatabase('{{DbName}}');
        //$id = $db->insert("INSERT INTO {{TableName}} ({{ProtectedPropsFillObj}}) VALUES({{QueryPropsFillCtor}})");
    }
}

?>