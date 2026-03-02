<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] !== $_POST['confirm_password']) {
        renderView('signup', [
            'title' => 'สมัครสมาชิก',
            'error' => 'รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน'
        ]);
        exit;
    }

    $user = [
        'name' => $_POST['name'] ?? '',
        'gender' => $_POST['gender'] ?? '',
        'birth_date' => $_POST['birth_date'] ?? '',
        'occupation' => $_POST['occupation'] ?? '',
        'province' => $_POST['province'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ];

    if (insertUser($user)) {
        renderView('signup-success', ['title' => 'สมัครสมาชิกสำเร็จ']);
    } else {
        echo "Error inserting user.";
    }
} else {
    renderView('signup', ['title' => 'สมัครสมาชิก']);
}