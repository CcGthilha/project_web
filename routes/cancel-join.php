<?php
// /routes/cancel-join.php (หรือชื่อไฟล์ของคุณ)
session_start();

// ตรวจสอบว่าล็อกอินอยู่ และส่งข้อมูลมาแบบ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    
    $user_id = $_SESSION['user_id'];
    $event_id = (int)$_POST['event_id'];

    // หา URL เดิมเพื่อส่งกลับไปที่หน้าเดิม
    $return_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/main';

    // เรียกฟังก์ชันเพื่อลบข้อมูลการสมัคร
    if (cancelRegistration($user_id, $event_id)) {
        // เก็บข้อความสำเร็จลง Session เพื่อให้ header.php ในหน้าถัดไปแสดงผล
        $_SESSION['msg_success'] = 'ยกเลิกการเข้าร่วมกิจกรรมเรียบร้อยแล้ว';
    } else {
        // เก็บข้อความแสดงข้อผิดพลาด
        $_SESSION['msg_error'] = 'เกิดข้อผิดพลาดในการยกเลิกกรุณาลองใหม่อีกครั้ง';
    }

    // Redirect กลับหน้าเดิมทันที
    header("Location: $return_url");
    exit();
    
} else {
    // ถ้าไม่ได้ล็อกอิน หรือเข้าถึงไม่ถูกต้อง
    header('Location: /login');
    exit();
}
?>