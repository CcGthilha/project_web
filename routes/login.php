<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = checkLogin($username, $password); 
    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: /main');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }

} else{
    renderView('login');
}
