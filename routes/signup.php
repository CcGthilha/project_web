<?php
// routes/signup.php
<<<<<<< HEAD
=======

>>>>>>> c7751dc32b323978e065351513328fbbb6fa3c9c
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. เช็คว่ารหัสผ่านตรงกันหรือไม่ (Confirm Password)
    if ($_POST['password'] !== $_POST['confirm_password']) {
        renderView('signup', [
            'title' => 'สมัครสมาชิก',
            'error' => 'รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน'
        ]);
        exit;
    }

<<<<<<< HEAD
    // ดึงค่าชื่อและอีเมลมาก่อนเพื่อใช้ตรวจสอบ
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    //  เช็คว่าชื่อหรืออีเมลซ้ำกับในระบบหรือไม่ 🌟
    if (checkDuplicateUser($name, $email)) {
        renderView('signup', [
            'title' => 'สมัครสมาชิก',
            'error' => 'ชื่อหรืออีเมลนี้มีผู้ใช้งานแล้ว กรุณาใช้ข้อมูลอื่น'
        ]);
        exit; // หยุดการทำงานทันที ป้องกันการบันทึกข้อมูลซ้ำ
    }

    // 3. ถ้าผ่านเงื่อนไข ค่อยนำข้อมูลมาเตรียมบันทึก
=======
>>>>>>> c7751dc32b323978e065351513328fbbb6fa3c9c
    $user = [
        'name' => $name, // ใช้ตัวแปรที่ประกาศไว้ด้านบนได้เลย
        'gender' => $_POST['gender'] ?? '',
        'birth_date' => $_POST['birth_date'] ?? '',
        'occupation' => $_POST['occupation'] ?? '',
        'province' => $_POST['province'] ?? '',
        'email' => $email, // ใช้ตัวแปรที่ประกาศไว้ด้านบนได้เลย
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
