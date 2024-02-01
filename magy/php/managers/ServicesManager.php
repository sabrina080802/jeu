<?php

namespace Magy\Managers;

use Magy\Utils\ArrayExtension;
use Magy\Utils\StringsHelper;

class ServicesManager
{
    public static function generateEntityService($modelData, $fileContent, $tableInfos, $columns)
    {
        $classContent = substr($fileContent, strpos($fileContent, 'abstract class'));
        $classContent = trim(substr($classContent, strpos($classContent, '{') + 1));
        $matchCount = preg_match_all('/(\t|\s+)?(public|private)\sabstract\sfunction\s(.+?)\(([a-z\_\-0-9=$A-Z,\s]*)\)\s?(:\s?[a-zA-Z0-9\_\-]+)?;?/', $fileContent, $matches);
        for ($i = 0; $i < $matchCount; $i++) {
            //var_dump($matches[0][$i]);
            $returnType = str_replace([':', ' '], '', $matches[5][$i]);
            if ($returnType != 'void' && $returnType != 'ArrayExtension') {
                $returnType .= '|null';
            }
            $record = PHP_EOL . "\t" . $matches[2][$i] . " static function " . $matches[3][$i] . "(" . $matches[4][$i] . "):" . $returnType . PHP_EOL;
            $record .= "\t{" . PHP_EOL;

            $record .=  self::generateFunctionContent(
                $modelData,
                $columns,
                $matches[3][$i],
                $matches[4][$i],
                $returnType
            ) . PHP_EOL;
            $record .= "\t}" . PHP_EOL;

            $fileContent = str_replace($matches[0][$i], $record, $fileContent);
        }

        $fileContent = str_replace('abstract class', 'class', $fileContent);
        file_put_contents(MAGY_PATH . 'app/services/' . $modelData['EntityName'] . 'Service.php', $fileContent);
    }
    private static function generateFunctionContent($modelData, $columns, $name, $parameters, $returnType)
    {
        $result = '';

        $recordType = self::getRecordTypeFromName($name);
        if ($recordType == 'UNKNOWN') {
            return "\t\tthrow new \\Exception(\"Unrecognized abstract function signature\");";
        }

        $result .= "\t\t\$db = DbManager::getDatabase('" . $modelData['DbName'] . "');" . PHP_EOL;

        switch ($recordType) {
            case 'GET':
                $result .= self::generateGetLine($modelData, $columns, $parameters, $returnType);
                break;
        }

        return $result;
    }
    private static function generateGetLine($modelData, $columns, $parameters, $returnType)
    {
        $line = "\t\t\$data = \$db->";
        $query = 'SELECT * FROM `' . $modelData['TableName'] . '`';
        $params = "[";
        if ($returnType == 'ArrayExtension') {
            $line .= 'query(';
        } else {
            $returnType .= '|null';
            $line .= 'first(';
        }

        if (strlen($parameters) > 0) {
            $query .= ' WHERE';
            $parameters = new ArrayExtension(explode(',', $parameters));

            for ($i = 0; $i < $parameters->count(); $i++) {
                if ($parameters[$i] == '') continue;
                $parameters[$i] = trim($parameters[$i]);
                $paramName = StringsHelper::toUnderscoreCase(substr($parameters[$i], 1));
                $columnFound = false;
                for ($j = 0; $j < $columns->count(); $j++) {
                    if (strtolower($columns[$j]['COLUMN_NAME']) == $paramName) {
                        $columnFound = true;
                        if ($i > 0) {
                            $query .= ' AND';
                        }
                        $query .= " " . $columns[$j]['COLUMN_NAME'] . ' = :' . $paramName;
                        $params .= PHP_EOL . "\t\t\t\"" . $paramName . '" => ' . $parameters[$i] . ',';
                        break;
                    }
                }

                if (!$columnFound) {
                    return "\t\tthrow new \\Exception('Column " . $paramName . " not found in your entity');" . PHP_EOL;
                }
            }

            $params .= PHP_EOL . "\t\t";
        }

        $line .= '"' . $query . ';", ' . $params . ']);' . PHP_EOL;
        if ($returnType == 'ArrayExtension') {
            $line .= "\t\tfor(\$i = 0;\$i < \$data->count();\$i++){" . PHP_EOL;
            $line .= "\t\t\t\$data->push(new " . $modelData['EntityName'] . '(';
            for ($i = 0; $i < $columns->count(); $i++) {
                if ($i > 0) {
                    $line .= ', ';
                }
                $line .= '$data["' . $columns[$i]['COLUMN_NAME'] . '"]';
            }
            $line .= '));' . PHP_EOL . "\t\t}" . PHP_EOL;
            return $line . "\t\treturn \$data;";
        } else {
            $line .= "\t\treturn \$data == null ? null : new " . $modelData['EntityName'] . '(';
            for ($i = 0; $i < $columns->count(); $i++) {
                if ($i > 0) {
                    $line .= ', ';
                }
                $line .= '$data["' . $columns[$i]['COLUMN_NAME'] . '"]';
            }
            return $line . ');';
        }
    }
    private static function getRecordTypeFromName($name)
    {
        switch (true) {
            case preg_match('/^(get|find)/', $name):
                return 'GET';
            case preg_match('/^(delete)/', $name);
                return 'DELETE';
            case preg_match('/^(update)/', $name);
                return 'UPDATE';
            default:
                return 'UNKNOWN';
        }
    }
}
