<?php
// ฟังก์ชันสำหรับดึงรายชื่อคนเข้าร่วมกิจกรรม
function getParticipantsByEventId(int $event_id): mysqli_result|bool {
    global $conn;
    $sql = "SELECT r.*, u.name, u.email 
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

// ฟังก์ชันสำหรับบันทึกการเข้าร่วม (สำหรับไฟล์ join-event.php)
function joinEvent(int $user_id, int $event_id): bool {
    global $conn;
    $sql = "INSERT INTO registrations (user_id, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    return $stmt->execute();
}
// ฟังก์ชันสำหรับอัปเดตสถานะการเข้าร่วม
function updateRegistrationStatus(int $reg_id, string $status): bool {
    global $conn;
    $sql = "UPDATE registrations SET status = ? WHERE reg_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $reg_id);
    return $stmt->execute();
}

// ฟังก์ชันสำหรับเช็คว่าผู้ใช้เคยขอเข้าร่วมกิจกรรมนี้ไปแล้วหรือยัง
function isAlreadyJoined(int $user_id, int $event_id): bool {
    global $conn;
    $sql = "SELECT registrations_id FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // ถ้าเจอข้อมูลแปลว่าเคยขอเข้าร่วมแล้ว
}