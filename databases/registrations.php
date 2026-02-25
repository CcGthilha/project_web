<?php
// ฟังก์ชันสำหรับดึงรายชื่อคนเข้าร่วมกิจกรรม
function getParticipantsByEventId(int $event_id): mysqli_result|bool
{
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
function joinEvent(int $user_id, int $event_id): bool
{
    global $conn;
    $sql = "INSERT INTO registrations (user_id, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    return $stmt->execute();
}

// ฟังก์ชันสำหรับอัปเดตสถานะการเข้าร่วม
function getRegistrationStatus(int $user_id, int $event_id) {

    global $conn;
    $sql = "SELECT status FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // ถ้าเจอข้อมูล ให้ส่งคำสถานะกลับไป
    if ($row = $result->fetch_assoc()) {
        return $row['status']; 
    }
    return false; // ถ้าไม่เจอแปลว่ายังไม่เคยเข้าร่วม
}

// ฟังก์ชันสำหรับเช็คว่าผู้ใช้เคยขอเข้าร่วมกิจกรรมนี้ไปแล้วหรือยัง
function isAlreadyJoined(int $user_id, int $event_id): bool
{
    global $conn;
    $sql = "SELECT registrations_id FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // ถ้าเจอข้อมูลแปลว่าเคยขอเข้าร่วมแล้ว
}

// ฟังก์ชันสำหรับยกเลิกการเข้าร่วมกิจกรรม (ถ้าอยากเพิ่มฟีเจอร์นี้ในอนาคต)
function cancelRegistration(int $user_id, int $event_id): bool 
{
    global $conn;
    // สั่งลบข้อมูลคนที่ตรงกับ user_id และ event_id นี้ทิ้งซะ
    $sql = "DELETE FROM registrations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    return $stmt->execute();
}