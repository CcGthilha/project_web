<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

<<<<<<< HEAD
    $user = checkLogin($username, $password);
    if ($user) {
        $_SESSION['timestamp'] = time();
=======
    $user = checkLogin($username, $password); 
    if ($user) {
>>>>>>> c7751dc32b323978e065351513328fbbb6fa3c9c
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: /main');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }

} else{
    renderView('login');
}
