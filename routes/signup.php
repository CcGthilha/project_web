<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. เช็คว่ารหัสผ่านตรงกันหรือไม่ (Confirm Password)
    if ($_POST['password'] !== $_POST['confirm_password']) {
        // ถ้ารหัสไม่ตรง ให้ส่ง error กลับไปที่หน้าสมัครสมาชิก
        renderView('signup', [
            'title' => 'สมัครสมาชิก',
            'error' => 'รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน'
        ]);
        exit; // หยุดการทำงาน ไม่ให้ไปถึงขั้นตอนการสมัคร
    }

    // 2. ถ้าผ่านเงื่อนไข ค่อยนำข้อมูลมาเตรียมบันทึก
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
}