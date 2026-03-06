<?php
// routes/otp-user.php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดูรหัสเข้างาน'); 
        window.location.href='/login';</script>";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = (int)$_POST['event_id'];
} else {
    $event_id = (int)$_GET['event_id'];
}

// เรียกฟังก์ชันคำนวณรหัส (ระบบจะสร้างเลข 6 หลักให้เองตามเวลา)
$current_otp = generateStatelessOTP($_SESSION['user_id'], $event_id);

// ส่งรหัสไปแสดงที่หน้าเว็บ
renderView('otp-user', [
    'title' => 'รหัสเข้างานของคุณ',
    'otp' => $current_otp,
    'event_id' => $event_id
]);
?>