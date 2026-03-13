<?php
// /routes/chpw.php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    // กรณีไม่มี ID ส่งมา ให้เก็บ error และเด้งกลับ
    $_SESSION['msg_error'] = 'ไม่พบข้อมูลผู้ใช้งานที่ต้องการแก้ไข';
    header('Location: /personal');
    exit;
} else {
    $id = (int)$_GET['id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // เช็คความตรงกันอีกครั้งที่ Backend เพื่อความปลอดภัย
        if ($password !== $confirm_password) {
            $_SESSION['msg_error'] = 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน';
            header("Location: /chpw?id=$id");
            exit;
        }

        // แฮชรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $res = updateUserPassword($id, $hashed_password);

        if ($res > 0) {
            // ✅ สำเร็จ: เก็บข้อความสำเร็จแล้วส่งกลับหน้าโปรไฟล์
            $_SESSION['msg_success'] = 'เปลี่ยนรหัสผ่านใหม่เรียบร้อยแล้ว';
            header('Location: /personal');
            exit;
        } else {
            // ❌ ผิดพลาด: กรณี Database อัปเดตไม่ได้
            $_SESSION['msg_error'] = 'ไม่สามารถอัปเดตรหัสผ่านได้ หรือคุณใช้รหัสเดิม';
            header("Location: /chpw?id=$id");
            exit;
        }
    } else {
        // กรณีโหลดหน้าฟอร์ม (GET)
        $res = getUserById($id);
        if ($res) {
            renderView('chpw', array('result' => $res));
        } else {
            $_SESSION['msg_error'] = 'ไม่พบข้อมูลผู้ใช้งานในระบบ';
            header('Location: /personal');
            exit;
        }
    }
}