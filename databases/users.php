<?php
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

function checkLogin(string $email, string $password): array|null
{
    global $conn;
    $sql = 'select * from users where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            return $row; 
        }
    }
    return null; 
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

    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $data['email']);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        return "email_exists";
    }

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

function checkDuplicateUser(string $name, string $email): bool 
{
    global $conn;
    
    // ค้นหาว่ามีชื่อ หรือ อีเมล นี้อยู่ในระบบแล้วหรือยัง
    $sql = "SELECT user_id FROM users WHERE name = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $name, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // ถ้าเจอข้อมูลมากกว่า 0 แถว แปลว่า "ซ้ำ" (return true)
    if ($result->num_rows > 0) {
        return true; 
    }
    
    // ถ้าไม่เจอเลย แปลว่า "ไม่ซ้ำ" สมัครได้ (return false)
    return false; 
}