<?php

include "../config.php";
include "Autoloader.php";

use Magy\Database\Database;

if (!isset($_GET['dbuser']) || !isset($_GET['dbpass'])) {
    http_response_code(404);
    exit;
}
if (isset($_GET['dbhost'])) {
    $dbHost = $_GET['dbhost'];
} else {
    $dbHost = '127.0.0.1';
}

$dbUser = $_GET['dbuser'];
$dbPass = $_GET['dbpass'];

$dbConfigList = scandir(CONFIG_PATH . 'Databases');

$schemaDb = new Database($dbHost, 'information_schema', $dbUser, $dbPass);

$configCount = sizeof($dbConfigList);
for ($i = 2; $i < $configCount; $i++) {
    $dbName = str_replace('.php', '', $dbConfigList[$i]);
    $db = new Database($dbHost, $dbName, $dbUser, $dbPass);
    $db->configure($schemaDb);
}
