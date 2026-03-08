<?php
// routes/verify-otp.php

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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp_code'])) { 
    
    $event_id = (int)$_POST['event_id'];
    $otp_input = trim($_POST['otp_code']); 

    // ตรวจสอบรหัส (จะได้ข้อมูลกลับมาเป็น Array)
    $verify_data = verifyStatelessOTP($event_id, $otp_input);

    // แยกกรณีแจ้งเตือนตามผลลัพธ์
    if ($verify_data['result'] === 'success') {
        
        // รหัสถูกต้องและเพิ่งใช้ครั้งแรก -> อัปเดตสถานะเป็นเข้าร่วมแล้ว
        markAsAttended($verify_data['registrations_id']);
        $attendee_name = $verify_data['name'];
        
        echo "<script>alert('✅ รหัสถูกต้อง! เช็คชื่อให้คุณ: $attendee_name เรียบร้อยแล้ว'); 
            window.location.href='/event-detail?event_id=" . $event_id . "';</script>"; 
            
    } else if ($verify_data['result'] === 'already_used') {
        
        // รหัสถูกต้อง แต่ถูกใช้เช็คชื่อไปก่อนหน้านี้แล้ว
        $attendee_name = $verify_data['name'];
        
        echo "<script>alert('⚠️ รหัสนี้ถูกใช้งานไปแล้ว! (คุณ $attendee_name ได้เช็คชื่อไปแล้ว)'); 
            window.location.href='/verify-otp?event_id=" . $event_id . "';</script>"; 
            
    } else {
        
        // รหัสไม่ตรงกับใครเลย หรือพิมพ์ผิด
        echo "<script>alert('❌ รหัสไม่ถูกต้อง หรือรหัสหมดอายุแล้ว!'); 
            window.location.href='/verify-otp?event_id=" . $event_id . "';</script>"; 
            
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