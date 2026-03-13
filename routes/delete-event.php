<?php
// /routes/delete-event.php
// สมมติว่าไฟล์ router ของคุณได้ทำการ session_start() และ include database ไว้แล้ว

if (isset($_GET['id'])) {
    $event_id = (int)$_GET['id'];

    // ดึงข้อมูลกิจกรรมมาตรวจสอบก่อนว่าเป็นของใคร
    $result = getEventByEventId($event_id);
    $event_data = $result ? $result->fetch_assoc() : null;

    // เช็คสิทธิ์: ต้องมีข้อมูลกิจกรรมนี้อยู่จริง และ User ID ต้องตรงกับคนที่ล็อกอิน
    if ($event_data && isset($_SESSION['user_id']) && $event_data['user_id'] == $_SESSION['user_id']) {
        
        // สิทธิ์ถูกต้อง สั่งลบกิจกรรมได้เลย
        if (deleteEvent($event_id)) {
            // ลบสำเร็จ เก็บข้อความลง Session
            $_SESSION['msg_success'] = 'ลบกิจกรรมเรียบร้อยแล้ว!';
        } else {
            // เกิดข้อผิดพลาดในระดับ Database
            $_SESSION['msg_error'] = 'เกิดข้อผิดพลาดในการลบกิจกรรม กรุณาลองใหม่อีกครั้ง';
        }

    } else {
        // กรณีไม่ใช่เจ้าของ หรือพยายามกรอก ID มั่วๆ ใน URL
        $_SESSION['msg_error'] = 'คุณไม่มีสิทธิ์ลบกิจกรรมนี้!';
    }
    
    // Redirect กลับไปหน้าหลักของกิจกรรม
    header('Location: /events');
    exit();

} else {
    // ถ้าไม่มีการส่ง ID มา ให้เด้งกลับไปหน้ากิจกรรมเลย
    header('Location: /events');
    exit();
}
?>