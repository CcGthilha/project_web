<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = (int)$_POST['event_id'];

    // 1. ตรวจสอบก่อนว่าเคยเข้าร่วมไปแล้วหรือยัง
    if (isAlreadyJoined($user_id, $event_id)) {
        echo "<script>alert('คุณได้ส่งคำขอเข้าร่วมกิจกรรมนี้ไปแล้ว ไม่สามารถขอซ้ำได้'); window.history.back();</script>";
        exit();
    }

    // 2. ถ้ายังไม่เคยเข้าร่วม ถึงจะยอมให้ Insert ข้อมูล
    if (joinEvent($user_id, $event_id)) {
        echo "<script>alert('เข้าร่วมกิจกรรมสำเร็จ!'); window.location.href='/event-detail?id=$event_id';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการส่งคำขอ'); window.history.back();</script>";
    }
    exit();
} else {
    header('Location: /login');
    exit();
}