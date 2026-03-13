<?php
// /routes/join-event.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = (int)$_POST['event_id'];

    // กำหนด URL สำหรับ Redirect กลับ (ถ้าไม่มี referer ให้ไปหน้า main)
    $return_url = $_SERVER['HTTP_REFERER'] ?? '/main';

    // 1. ตรวจสอบว่าเคยเข้าร่วมหรือยัง
    if (isAlreadyJoined($user_id, $event_id)) {
        $_SESSION['msg_error'] = 'คุณได้ส่งคำขอเข้าร่วมกิจกรรมนี้ไปแล้ว';
        header("Location: $return_url");
        exit();
    }

    global $conn; 
    $stmt = $conn->prepare("SELECT description FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event_data = $stmt->get_result()->fetch_assoc();

    if ($event_data) {
        $max_limit_check = 0;
        if (preg_match('/\[MAX:(\d+)\]/i', $event_data['description'], $matches)) {
            $max_limit_check = (int)$matches[1];
        }

        if ($max_limit_check > 0) {
            $current_joined_check = getParticipantCount($event_id); 
            if ($current_joined_check >= $max_limit_check) {
                $_SESSION['msg_error'] = 'ขออภัยครับ กิจกรรมนี้มีผู้เข้าร่วมเต็มจำนวนแล้ว!';
                header("Location: $return_url");
                exit();
            }
        }
    }

    // 2. ลองทำการ Insert ข้อมูล
    if (joinEvent($user_id, $event_id)) {
        $_SESSION['msg_success'] = 'ส่งคำขอเข้าร่วมกิจกรรมสำเร็จ!';
    } else {
        $_SESSION['msg_error'] = 'เกิดข้อผิดพลาดในการส่งคำขอ';
    }
    
    header("Location: $return_url");
    exit();

} else {
    header('Location: /login');
    exit();
}