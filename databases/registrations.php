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

// database/registrations.php
// 1. ฟังก์ชันสร้างรหัส OTP แบบไม่พึ่งฐานข้อมูล (คำนวณตามเวลา 30 นาที)
function generateStatelessOTP(int $user_id, int $event_id, $timestamp = null) {
    // กำหนด Secret Key ของเว็บเรา (ตั้งเป็นคำอะไรก็ได้)
    $secret_key = "MySuperSecretEventKey2026"; 
    
    if ($timestamp === null) {
        $timestamp = time(); // ใช้เวลาปัจจุบัน
    }
    
    // แบ่งเวลาเป็นบล็อก บล็อกละ 30 นาที (1800 วินาที)
    $time_window = floor($timestamp / 1800);
    
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
    
    // โค้ดใหม่: ดึง "ทุกคน" ที่อยู่ในงานนี้มาเช็ค (ตัด WHERE r.status = 'approved' ออก)
    $sql = "SELECT r.registrations_id, r.status, u.user_id, u.name 
            FROM registrations r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $current_time = time();
    
    while ($row = $result->fetch_assoc()) {
        $expected_otp_current = generateStatelessOTP($row['user_id'], $event_id, $current_time);
        $expected_otp_prev = generateStatelessOTP($row['user_id'], $event_id, $current_time - 1800);
        
        // ถ้ารหัสที่กรอกมา ตรงกับรหัสของคนๆ นี้
        if ($input_otp === $expected_otp_current || $input_otp === $expected_otp_prev) {
            
            // เช็คสถานะว่าเป็นอะไร
            if ($row['status'] === 'approved') {
                return [
                    'result' => 'success', // รหัสถูกและยังไม่เคยใช้
                    'registrations_id' => $row['registrations_id'],
                    'name' => $row['name']
                ];
            } else if ($row['status'] === 'attended') { 
                // หมายเหตุ: ถ้าในฐานข้อมูลคุณใช้คำอื่นแทน attended (เช่น joined) ให้แก้ตรงนี้นะครับ
                return [
                    'result' => 'already_used', // รหัสถูก แต่ใช้ไปแล้ว
                    'name' => $row['name']
                ];
            }
        }
    }
    
    // ถ้าวนลูปจนครบทุกคนแล้วรหัสยังไม่ตรงกับใครเลย
    return [
        'result' => 'invalid' // รหัสผิด หรือ หมดเวลา
    ]; 
}

//ฟังก์ชันสำหรับเปลี่ยนสถานะว่า "เข้าร่วมงานแล้ว"
function markAsAttended(int $registrations_id) {
    global $conn;
    // เปลี่ยนสถานะจาก approved เป็น attended (ถ้าฐานข้อมูลคุณใช้คำอื่น เช่น 'joined' ให้แก้ตรงนี้นะครับ)
    $sql = "UPDATE registrations SET status = 'attended' WHERE registrations_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $registrations_id);
    return $stmt->execute();
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

function getParticipantCount($event_id) {
    global $conn; // ใช้ตัวแปรเชื่อมต่อฐานข้อมูลของคุณ
    
    // นับเฉพาะคนที่สถานะเป็น approved (อนุมัติแล้ว) หรือ attended (เข้าร่วมแล้ว)
    $sql = "SELECT COUNT(*) as total FROM registrations WHERE event_id = ? AND status IN ('approved', 'attended')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['total'] ?? 0;
}