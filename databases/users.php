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

function insertUser($data)
{
    global $conn;

    // 🔎 เช็ค email ซ้ำก่อน
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $data['email']);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        return "email_exists";
    }

    // ✅ ถ้าไม่ซ้ำค่อย insert
    $stmt = $conn->prepare("
        INSERT INTO users 
        (name, gender, birth_date, occupation, province, email, password)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssss",
        $data['name'],
        $data['gender'],
        $data['birth_date'],
        $data['occupation'],
        $data['province'],
        $data['email'],
        $data['password']
    );

    return $stmt->execute();
}