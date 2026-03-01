<?php
// สมมติว่าไฟล์ router ของคุณได้ทำการ session_start() และ include database ไว้แล้ว

if (isset($_GET['id'])) {
    $event_id = (int)$_GET['id'];

    // ดึงข้อมูลกิจกรรมมาตรวจสอบก่อนว่าเป็นของใคร
    $result = getEventsById($event_id);
    $event_data = $result->fetch_assoc();

    // เช็คสิทธิ์: ต้องมีข้อมูลกิจกรรมนี้อยู่จริง และ User ID ต้องตรงกับคนที่ล็อกอิน
    if ($event_data && isset($_SESSION['user_id']) && $event_data['user_id'] == $_SESSION['user_id']) {
        
        // สิทธิ์ถูกต้อง สั่งลบกิจกรรมได้เลย
        if (deleteEvent($event_id)) {
            // ลบสำเร็จ ให้เด้งข้อความแจ้งเตือนและกลับไปหน้าหลัก
            echo "<script>alert('ลบกิจกรรมเรียบร้อยแล้ว!'); window.location.href='/events';</script>";
            exit();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบกิจกรรม'); window.location.href='/events';</script>";
            exit();
        }

    } else {
        // ถ้าแอบเปลี่ยน ID ใน URL หรือไม่ใช่เจ้าของ
        echo "<script>alert('คุณไม่มีสิทธิ์ลบกิจกรรมนี้!'); window.location.href='/events';</script>";
        exit();
    }
} else {
    // ถ้าไม่มีการส่ง ID มา ให้เด้งกลับไปหน้ากิจกรรมเลย
    header('Location: /events');
    exit();
}
?>