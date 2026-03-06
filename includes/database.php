<?php
declare(strict_types=1);
    // --- อัปเดตข้อมูลการเชื่อมต่อตาม Hosting ใหม่ ---
    $hostname = 'gonggang.net';
    $dbName   = 'u910454988_event4u';
    $username = 'u910454988_event4u';
    $password = 'F!c8InsR0G]2lgw9';
    
    $conn = new mysqli($hostname, $username, $password, $dbName);
    
    // เพิ่มบรรทัดนี้เพื่อป้องกันปัญหาภาษาไทยเป็นตัวต่างดาว (แนะนำ)
    $conn->set_charset("utf8mb4");

function getConnection(): mysqli
{
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
require_once DATABASES_DIR . '/users.php';
require_once DATABASES_DIR . '/events.php';
require_once DATABASES_DIR . '/registrations.php';
