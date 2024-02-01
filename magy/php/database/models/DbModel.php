<?php namespace App\Entity;

use Magy\Managers\DbManager;

class {{EntityName}}{
{{Properties}}
    public function __construct({{PropertiesCtor}}){
{{PropsFillObj}}    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete(){
        DbManager::getDatabase('{{DbName}}')
            ->execute('DELETE FROM {{TableName}} WHERE {{PrimaryKeysCondition}}');
    }

    /**
     * Update the record in database with entity data
     */
    public function update(){

    }

    public function copy():{{EntityName}}{
        return new {{EntityName}}({{CopyPropsFill}});
    }

    /**
     *@return {{EntityName}} A newly created {{TableName}} with given data
     */
    public static function create({{PropertiesCtor}}){
        $entity = new {{EntityName}}({{PropsFillCtor}});
        $db = DbManager::getDatabase('{{DbName}}');
        $db->insert("INSERT INTO {{TableName}} ({{ProtectedPropsFillObj}}) VALUES({{QueryPropsFillCtor}})", [
{{InsertReqFillObj}}        ]);
    }
}

?>