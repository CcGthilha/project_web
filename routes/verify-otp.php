<?php
// routes/verify-otp.php
session_start();

// ✅ แก้ไขเป็นรับค่าให้ครอบคลุมทั้ง GET และ POST แบบนี้ครับ:
$event_id = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
} else {
    $event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
}

if ($event_id === 0) {
    echo "<script>alert('ไม่พบกิจกรรมนี้ กรุณาเลือกกิจกรรมก่อน'); 
        window.location.href='/events';</script>"; // แนะนำให้เด้งกลับไปหน้าหน้ารวมกิจกรรม
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

// ... โค้ดส่วนล่าง (ตรวจรหัส OTP) ปล่อยไว้เหมือนเดิม
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp_code'])) { 
    // ไม่ใช่แค่การกดปุ่ม "ตรวจรหัสเข้างาน" มาจากหน้า event-detail

    $event_id = (int)$_POST['event_id'];
    $otp_input = trim($_POST['otp_code']); 

    // ตรวจสอบว่ารหัสนี้คือใคร
    $attendee_name = verifyStatelessOTP($event_id, $otp_input);

    if ($attendee_name) {
        
        echo "<script>alert('รหัสถูกต้อง! ผู้เข้าร่วม: $attendee_name'); 
            window.location.href='/events';</script>"; // แนะนำให้เด้งกลับไปหน้าหน้ารวมกิจกรรม
    } else {
        echo "<script>alert('รหัสไม่ถูกต้อง!'); 
            window.location.href='/events';</script>"; // แนะนำให้เด้งกลับไปหน้าหน้ารวมกิจกรรม
    }
    exit();

} else {
    // ถ้าเข้ามาแบบ GET หรือ POST มาจากปุ่ม event-detail (ไม่มี otp_code) ให้โชว์หน้ากรอกรหัส
    renderView('verify-otp', [
        'title' => 'จุดตรวจรหัสเข้างาน',
        'event_id' => $event_id
    ]);
}
?>