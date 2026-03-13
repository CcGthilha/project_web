<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $reg_id = (int)$_POST['reg_id'];
    $status = $_POST['status']; // 'approved' หรือ 'rejected'
    $event_id = (int)$_POST['event_id'];

    // เรียกใช้ฟังก์ชัน (ถ้าคนเต็ม ฟังก์ชันนี้จะรีเทิร์น false ออกมา)
    if (updateRegistrationStatus($reg_id, $status)) {
        header("Location: /view-participants?id=$event_id");
    } else {
        // 🌟 แยกข้อความแจ้งเตือนให้ชัดเจนขึ้น 🌟
        if ($status === 'approved') {
            // ถ้ากดอนุมัติแล้วพัง แปลว่าคนเต็มชัวร์!
            echo "<script>alert('❌ ไม่สามารถอนุมัติได้! จำนวนผู้เข้าร่วมกิจกรรมเต็มแล้ว กรุณาเพิ่มจำนวนรับสูงสุดก่อนครับ'); window.history.back();</script>";
        } else {
            // ถ้ากดปฏิเสธแล้วพัง ค่อยขึ้นข้อผิดพลาดทั่วไป
            echo "<script>alert('เกิดข้อผิดพลาดในการทำรายการ'); window.history.back();</script>";
        }
    }
    exit();
}