<?php
// routes/signup.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. เช็คว่ารหัสผ่านตรงกันหรือไม่ (Confirm Password)
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

    // 2. เรียกใช้ฟังก์ชัน insertUser และเก็บผลลัพธ์เพื่อเช็คอีเมลซ้ำ
    $result = insertUser($user);

    if ($result === true) {
        // สมัครสำเร็จ
        renderView('signup-success', ['title' => 'สมัครสมาชิกสำเร็จ']);
    } elseif ($result === "email_exists") {
        // แจ้งเตือนกรณีอีเมลซ้ำที่ Model ดักไว้
        renderView('signup', [
            'title' => 'สมัครสมาชิก',
            'error' => 'อีเมลนี้ถูกใช้งานไปแล้ว กรุณาใช้อีเมลอื่น'
        ]);
    } else {
        // กรณี Error อื่นๆ
        renderView('signup', [
            'title' => 'สมัครสมาชิก',
            'error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
        ]);
    }
} else {
    // สำหรับการเข้าหน้าสมัครสมาชิกปกติ (GET Method)
    renderView('signup', ['title' => 'สมัครสมาชิก']);
}