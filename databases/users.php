<?php
// ฟังก์ชันสำหรับดึงข้อมูลผู้ใช้จากฐานข้อมูล
function getUsers(): mysqli_result|bool
{
    global $conn;
    $sql = 'select * from users where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// ไฟล์ FinalProject/databases/users.php

function checkLogin(string $email, string $password): array|null // เปลี่ยน return type
{
    global $conn;
    // ปรับ Query ให้ดึงข้อมูลทั้งหมด เพื่อเอา user_id ออกมาด้วย
    $sql = 'select * from users where email = ?'; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            return $row; // คืนค่า array ของข้อมูลผู้ใช้ทั้งหมด
        }
    }
    return null; // คืนค่า null ถ้า Login ไม่สำเร็จ
}

function getUserById(int $id): mysqli_result|bool
{
    global $conn;
    $sql = 'select * from users where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function updateUserPassword(int $id, string $hashed_password): bool
{
    global $conn;
    $sql = 'update users set password = ? where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $hashed_password, $id);
    $stmt->execute();
    return  $stmt->affected_rows > 0;
}
