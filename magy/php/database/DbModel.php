<?php App\Entity;

class {{EntityName}}{
{{Properties}}
    public function __construct({{PropertiesCtor}}){
{{PropsFillObj}}    }
    public static function create({{PropertiesCtor}}){
        $entity = new {{EntityName}}({{PropsFillCtor}});
        $db = DbManager::getDatabase('{{DbName}}');
        $db->insert("INSERT INTO {{TableName}} ({{ProtectedPropsFillObj}}) VALUES({{QueryPropsFillCtor}})", [
{{InsertReqFillObj}}        ]);
    }
}

?>