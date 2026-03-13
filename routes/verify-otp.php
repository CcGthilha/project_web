<?php
// routes/verify-otp.php

// 1. ตรวจสอบ event_id จาก GET หรือ POST
$event_id = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
} else {
    $event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
}

// กรณีไม่พบกิจกรรม
if ($event_id === 0) {
    $_SESSION['msg_error'] = 'ไม่พบข้อมูลกิจกรรม กรุณาเลือกกิจกรรมก่อน';
    header('Location: /events');
    exit();
}

// ตรวจสอบการ Login
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

// 2. กรณีมีการส่งรหัส OTP มาตรวจสอบ (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp_code'])) { 
    
    $otp_input = trim($_POST['otp_code']); 

    // ตรวจสอบรหัสผ่านฟังก์ชัน (คืนค่าเป็น Array)
    $verify_data = verifyStatelessOTP($event_id, $otp_input);

    if ($verify_data['result'] === 'success') {
        
        // ✅ รหัสถูกต้องและเพิ่งใช้ครั้งแรก
        markAsAttended($verify_data['registrations_id']);
        $attendee_name = $verify_data['name'];
        
        $_SESSION['msg_success'] = "รหัสถูกต้อง! เช็คชื่อให้คุณ $attendee_name เรียบร้อยแล้ว";
        header("Location: /event-detail?event_id=" . $event_id);
            
    } else if ($verify_data['result'] === 'already_used') {
        
        // ⚠️ รหัสถูกต้อง แต่ถูกใช้ไปแล้ว
        $attendee_name = $verify_data['name'];
        $_SESSION['msg_error'] = "รหัสนี้ถูกใช้งานไปแล้ว (คุณ $attendee_name เช็คชื่อไปแล้ว)";
        header("Location: /verify-otp?event_id=" . $event_id);
            
    } else {
        
        // ❌ รหัสไม่ถูกต้อง
        $_SESSION['msg_error'] = 'รหัสไม่ถูกต้อง หรือรหัสหมดอายุแล้ว!';
        header("Location: /verify-otp?event_id=" . $event_id);
    }
    exit();

} else {
    // 3. แสดงหน้าจอสำหรับกรอกรหัส (GET)
    renderView('verify-otp', [
        'title' => 'จุดตรวจรหัสเข้างาน',
        'event_id' => $event_id
    ]);
}
?>