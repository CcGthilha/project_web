<?php
// routes/signup.php
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
    $user = [
        'name' => $name, // ใช้ตัวแปรที่ประกาศไว้ด้านบนได้เลย
        'gender' => $_POST['gender'] ?? '',
        'birth_date' => $_POST['birth_date'] ?? '',
        'occupation' => $_POST['occupation'] ?? '',
        'province' => $_POST['province'] ?? '',
        'email' => $email, // ใช้ตัวแปรที่ประกาศไว้ด้านบนได้เลย
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
