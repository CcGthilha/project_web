<?php
// 1. ดักไว้ก่อนเลยว่าล็อกอินหรือยัง?
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

// 2. รับค่าสถานะจาก URL (เช่น ?status=approved) ถ้าไม่มีให้ค่าเริ่มต้นเป็น 'all'
$current_status = isset($_GET['status']) ? $_GET['status'] : 'all';

// 3. ดึงข้อมูลจากฐานข้อมูล
$result = getJoinedEventsByUser($_SESSION['user_id'], $current_status);

// 4. ส่งไปแสดงผลที่หน้า Template
renderView('list-join-events', [
    'title' => 'กิจกรรมที่คุณเข้าร่วม',
    'result' => $result,
    'current_status' => $current_status // ส่งสถานะปัจจุบันไปเพื่อทำสีปุ่มให้รู้ว่ากดเมนูไหนอยู่
]);
?>