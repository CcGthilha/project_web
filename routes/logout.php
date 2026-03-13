<?php
session_start();

// 1. เคลียร์ค่าใน Array $_SESSION
$_SESSION = array();

// 2. ลบคุกกี้ Session ที่อยู่ในเบราว์เซอร์
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. ทำลาย Session บน Server
session_destroy();

// 4. ไปหน้า Logout Success
header('Location: /logout-success');
exit();