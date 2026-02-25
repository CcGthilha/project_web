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
        // 🌟 ตัวช่วยสำคัญ: หาว่าผู้ใช้กดปุ่มมาจากหน้าเว็บไหน (URL อะไร)
        if (isset($_SERVER['HTTP_REFERER'])) {
            $return_url = $_SERVER['HTTP_REFERER'];
        } else {
            $return_url = '/main?id=' . $event_id;
        }
        echo "<script>alert('เข้าร่วมกิจกรรมสำเร็จ!'); window.location.href='$return_url';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการส่งคำขอ'); window.history.back();</script>";
    }
    exit();
} else {
    header('Location: /login');
    exit();
}