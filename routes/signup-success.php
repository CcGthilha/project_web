<?php
// แก้ไขไฟล์ FinalProject/routes/signup.php
if (insertUser($user)) {
    renderView('signup-success', ['title' => 'สมัครสมาชิกสำเร็จ']); // เพิ่ม array ข้อมูลที่ต้องการส่ง
}