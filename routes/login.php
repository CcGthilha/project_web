<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = checkLogin($username, $password); // เรียกใช้ฟังก์ชันที่แก้ใหม่
    if ($user) {
        $_SESSION['timestamp'] = time();
        $_SESSION['user_id'] = $user['user_id']; // บันทึก ID ลง Session ตรงนี้
        header('Location: /main');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }
} else {
    renderView('login');
}
