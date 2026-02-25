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

// ฟังก์ชันสำหรับดึงกิจกรรมที่ผู้ใช้เข้าร่วม พร้อมสถานะการเข้าร่วม (สำหรับหน้า list-join-events.php)
function getJoinedEventsByUser(int $user_id, string $status = 'all'): mysqli_result|bool 
{
    global $conn;
    
    // ดึงข้อมูลกิจกรรม + ชื่อคนสร้าง + รูปภาพ + สถานะการเข้าร่วม
    $sql = "SELECT e.*, u.name AS creator_name, ei.image_path, r.status AS join_status
            FROM events e
            JOIN registrations r ON e.event_id = r.event_id
            JOIN users u ON e.user_id = u.user_id
            LEFT JOIN event_images ei ON e.event_id = ei.event_id
            WHERE r.user_id = ?";

    // ถ้ามีการเลือกสถานะ (ไม่ใช่ all) ให้เพิ่มเงื่อนไข WHERE เข้าไป
    if ($status !== 'all') {
        $sql .= " AND r.status = ?";
    }
    
    // จัดกลุ่มและเรียงตามวันที่เริ่มกิจกรรม
    $sql .= " GROUP BY e.event_id ORDER BY e.start_date ASC";

    $stmt = $conn->prepare($sql);

    // Bind Parameter ตามเงื่อนไข
    if ($status !== 'all') {
        $stmt->bind_param('is', $user_id, $status);
    } else {
        $stmt->bind_param('i', $user_id);
    }

    $stmt->execute();
    return $stmt->get_result();
}