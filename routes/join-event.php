<?php
// /routes/join-event.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = (int)$_POST['event_id'];

    // ตรวจสอบก่อนว่าเคยเข้าร่วมไปแล้วหรือยัง
    if (isAlreadyJoined($user_id, $event_id)) {
        echo "<script>alert('คุณได้ส่งคำขอเข้าร่วมกิจกรรมนี้ไปแล้ว ไม่สามารถขอซ้ำได้'); window.history.back();</script>";
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
                // 🛑 คนเต็มแล้ว! เตือนแล้วเตะกลับหน้าเดิม 🛑
                echo "<script>
                        alert('❌ ขออภัยครับ กิจกรรมนี้มีผู้เข้าร่วมเต็มจำนวนแล้ว!'); 
                        window.history.back();
                      </script>";
                exit(); // 🛑 สั่งหยุดการทำงานตรงนี้เลย โค้ดด้านล่างจะไม่ถูกรัน
            }
        }
    }

    // ถ้ายังไม่เคยเข้าร่วม ถึงจะยอมให้ Insert ข้อมูล
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