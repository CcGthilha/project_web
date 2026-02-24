<?php

declare(strict_types=1);
function getConnection(): mysqli
{
    $hostname = 'localhost';
    $dbName = 'projectweb';
    $username = 'project';
    $password = 'projectweb1';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
require_once DATABASES_DIR . '/users.php';
require_once DATABASES_DIR . '/events.php';
require_once DATABASES_DIR . '/registrations.php';