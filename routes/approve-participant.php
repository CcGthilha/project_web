<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $reg_id = (int)$_POST['reg_id'];
    $status = $_POST['status']; // 'approved' หรือ 'rejected'
    $event_id = (int)$_POST['event_id'];

    if (updateRegistrationStatus($reg_id, $status)) {
        header("Location: /view-participants?id=$event_id");
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
    exit();
} 