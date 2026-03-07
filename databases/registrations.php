<?php
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

// ฟังก์ชันสำหรับอัปเดตสถานะการเข้าร่วม (อนุมัติ/ปฏิเสธ) สำหรับไฟล์ manage-registrations.php
function updateRegistrationStatus(int $reg_id, string $status): bool
{
    global $conn;
    $sql = "UPDATE registrations SET status = ? WHERE registrations_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $reg_id);
    return $stmt->execute();
}

// 1. ฟังก์ชันสร้างรหัส OTP แบบไม่พึ่งฐานข้อมูล (คำนวณตามเวลา 30 นาที)
function generateStatelessOTP(int $user_id, int $event_id, $timestamp = null) {
    // กำหนด Secret Key ของเว็บเรา (ตั้งเป็นคำอะไรก็ได้)
    $secret_key = "MySuperSecretEventKey2026"; 
    
    if ($timestamp === null) {
        $timestamp = time(); // ใช้เวลาปัจจุบัน
    }
    
    // แบ่งเวลาเป็นบล็อก บล็อกละ 30 นาที (1800 วินาที)
    $time_window = floor($timestamp / 20);
    
    // นำ ID ผู้ใช้ + ID งาน + บล็อกเวลา มาผสมกัน
    $data_string = $user_id . '_' . $event_id . '_' . $time_window;
    
    // เข้ารหัสด้วย HMAC SHA256 เพื่อความปลอดภัย
    $hash = hash_hmac('sha256', $data_string, $secret_key);
    
    // แปลงตัวอักษรเป็นตัวเลข แล้วตัดมาแค่ 6 หลัก
    $dec = hexdec(substr($hash, 0, 8));
    $otp = str_pad($dec % 1000000, 6, '0', STR_PAD_LEFT);
    
    return $otp;
}

// 2. ฟังก์ชันสำหรับผู้จัด เพื่อวนลูปหาว่ารหัสนี้เป็นของใคร
function verifyStatelessOTP(int $event_id, string $input_otp) {
    global $conn;
    
    // 1. ดึงรายชื่อผู้ที่ "ผ่านการอนุมัติ" ในงานนี้ทั้งหมดมาเช็ค
    $sql = "SELECT r.registrations_id, u.user_id, u.name 
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ? AND r.status = 'approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $current_time = time();
    
    // 2. วนลูปเช็คว่ารหัสที่กรอกมา ตรงกับสมการของใครในเวลานี้
    while ($row = $result->fetch_assoc()) {
        // คำนวณรหัสของคนๆ นี้ ในช่วงเวลาปัจจุบัน
        $expected_otp_current = generateStatelessOTP($row['user_id'], $event_id, $current_time);
        
        // คำนวณรหัสในช่วงเวลาที่แล้วด้วย (เผื่อผู้ใช้เปิดรหัสค้างไว้ตอนคาบเกี่ยวเปลี่ยนบล็อกเวลาพอดี)
        $expected_otp_prev = generateStatelessOTP($row['user_id'], $event_id, $current_time - 20);
        
        // ถ้ารหัสที่ผู้จัดพิมพ์มา ตรงกับคนๆ นี้
        if ($input_otp === $expected_otp_current || $input_otp === $expected_otp_prev) {
            return $row['name']; // ส่งชื่อคนๆ นั้นกลับไป
        }
    }
    return false; // ไม่ตรงกับใครเลย หรือรหัสหมดอายุ
}


function getParticipantsByEventId(int $event_id): mysqli_result|bool
{
    global $conn;
    // เพิ่มการดึงข้อมูล gender, birth_date, occupation, province จากตาราง users
    $sql = "SELECT r.*, u.name, u.email, u.gender, u.birth_date, u.occupation, u.province 
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    return $stmt->get_result();
}