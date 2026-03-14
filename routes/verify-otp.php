<?php
// routes/verify-otp.php

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}
$user_id = $_SESSION['user_id'];

// 2. รับค่า event_id แบบปลอดภัย (ดักจับตัวเลข)
$event_id = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
} else {
    $event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
}

if ($event_id === 0 || !isUserEventOrganizer($user_id, $event_id)) {
    $_SESSION['msg_error'] = 'ไม่พบข้อมูลกิจกรรม หรือคุณไม่มีสิทธิ์ตรวจตั๋วงานนี้!';
    header('Location: /events');
    exit();
}

// 4. กรณีสตาฟกดปุ่ม "ตรวจสอบรหัส" (POST Request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp_code'])) { 
    
    $otp_input = trim($_POST['otp_code']); 

    // โยนรหัสเข้าฟังก์ชันไปตรวจสอบว่าตรงกับใครไหม
    $verify_data = verifyStatelessOTP($event_id, $otp_input);

    // แยกย้ายตามผลลัพธ์
    if ($verify_data['result'] === 'success') {
        
        // ✅ รหัสถูกต้องและเพิ่งใช้ครั้งแรก (ตั๋วแท้)
        markAsAttended($verify_data['registrations_id']);
        $attendee_name = $verify_data['name'];
        
        $_SESSION['msg_success'] = "รหัสถูกต้อง! เช็คชื่อให้คุณ $attendee_name เรียบร้อยแล้ว";
        header("Location: /event-detail?event_id=" . $event_id); // หรือจะให้อยู่หน้าเดิมก็ได้นะครับ
            
    } else if ($verify_data['result'] === 'already_used') {
        
        // ⚠️ รหัสถูกต้อง แต่ถูกใช้ไปแล้ว (ตั๋วผี)
        $attendee_name = $verify_data['name'];
        $_SESSION['msg_error'] = "รหัสนี้ถูกใช้งานไปแล้ว (คุณ $attendee_name เช็คชื่อไปแล้ว)";
        header("Location: /verify-otp?event_id=" . $event_id);
            
    } else {
        
        // ❌ รหัสไม่ถูกต้อง (มั่วเลขมา)
        $_SESSION['msg_error'] = 'รหัสไม่ถูกต้อง หรือรหัสหมดอายุแล้ว!';
        header("Location: /verify-otp?event_id=" . $event_id);
    }
    exit();

} else {
    // 5. แสดงหน้าจอสำหรับกรอกรหัส (GET Request)
    // สำหรับตอนที่สตาฟเพิ่งเปิดเข้ามาหน้านี้ครั้งแรก
    renderView('verify-otp', [
        'title' => 'จุดตรวจรหัสเข้างาน',
        'event_id' => $event_id
    ]);
}
?>