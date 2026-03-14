<?php
// routes/otp-user.php

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดูรหัสเข้างาน'); 
        window.location.href='/login';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = (int)$_POST['event_id'];
} else {
    $event_id = (int)$_GET['event_id'];
}

$user_id = $_SESSION['user_id'];

if (!isUserApprovedForEvent($user_id, $event_id)) {
    $_SESSION['msg_error'] = 'คุณไม่มีสิทธิ์เข้าดูรหัสของงานนี้ หรือยังไม่ได้รับการอนุมัติ';
    header('Location: /main');
    exit();
}
$current_otp = generateStatelessOTP($user_id, $event_id);

renderView('otp-user', [
    'title' => 'รหัสเข้างานของคุณ',
    'otp' => $current_otp,
    'event_id' => $event_id
]);
?>