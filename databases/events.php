<?php
function getEvent(): mysqli_result|bool
{
    global $conn;
    // ใช้ GROUP BY e.event_id เพื่อให้แสดง 1 กิจกรรม ต่อ 1 แถวเท่านั้น
    $sql = 'SELECT e.*, u.name, ei.image_path 
            FROM events e 
            JOIN users u ON e.user_id = u.user_id 
            LEFT JOIN event_images ei ON e.event_id = ei.event_id 
            GROUP BY e.event_id 
            ORDER BY e.event_id';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result();
}
function getEventById(int $id): mysqli_result|bool
{
    global $conn;
    // เปลี่ยนจาก select * เป็น select e.*, u.name, ei.image_path
    $sql = 'SELECT e.*, u.name, ei.image_path FROM events e 
            JOIN users u ON e.user_id = u.user_id 
            LEFT JOIN event_images ei ON e.event_id = ei.event_id 
            WHERE e.user_id = ?';
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getEventByKeyword(string $keyword): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from events e join users u on e.user_id = u.user_id join event_images ei on e.event_id = ei.event_id where e.title like ? or u.name like ?';
    $stmt = $conn->prepare($sql);
    $keyword = '%'. $keyword .'%';
    $stmt->bind_param('ss',$keyword, $keyword);
    $res = $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getEventsById(int $id): mysqli_result|bool
{
    global $conn;
    // เปลี่ยนจาก select * เป็น select e.*, u.name, ei.image_path
    $sql = 'SELECT e.*, u.name, ei.image_path FROM events e 
            JOIN users u ON e.user_id = u.user_id 
            LEFT JOIN event_images ei ON e.event_id = ei.event_id 
            WHERE e.event_id = ?';
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateEvent($event_id, $title, $description, $location, $start_date, $end_date): bool
{
    global $conn;
    $sql = "UPDATE events SET title = ?, description = ?, location = ?, start_date = ?, end_date = ? WHERE event_id = ?";
    
    $stmt = $conn->prepare($sql);
    // sssssi คือ String 5 ตัว, Integer 1 ตัว (event_id)
    $stmt->bind_param('sssssi', $title, $description, $location, $start_date, $end_date, $event_id);
    
    return $stmt->execute();
}

function deleteEvent(int $event_id): bool
{
    global $conn;

    // 1. จัดการรูปลูก: ดึงชื่อไฟล์แล้วตามไปลบทิ้งจากโฟลเดอร์ public/uploads
    $sql_get_img = "SELECT image_path FROM event_images WHERE event_id = ?";
    $stmt_get_img = $conn->prepare($sql_get_img);
    $stmt_get_img->bind_param('i', $event_id);
    $stmt_get_img->execute();
    $res_img = $stmt_get_img->get_result();
    
    if ($row_img = $res_img->fetch_assoc()) {
        $file_path = '../public' . $row_img['image_path'];
        if (file_exists($file_path) && !empty($row_img['image_path'])) {
            unlink($file_path); // สั่งลบไฟล์
        }
    }

    // 2. ปลดล็อกที่ 1: ลบข้อมูลรูปในตาราง event_images 
    $sql_del_img = "DELETE FROM event_images WHERE event_id = ?";
    $stmt_del_img = $conn->prepare($sql_del_img);
    $stmt_del_img->bind_param('i', $event_id);
    $stmt_del_img->execute();

    // 3. ปลดล็อกที่ 2 (เพิ่มใหม่!): ลบข้อมูลคนเข้าร่วมจากตาราง registrations
    $sql_del_reg = "DELETE FROM registrations WHERE event_id = ?";
    $stmt_del_reg = $conn->prepare($sql_del_reg);
    $stmt_del_reg->bind_param('i', $event_id);
    $stmt_del_reg->execute();

    // 4. ลบกิจกรรมหลักในตาราง events ได้อย่างปลอดภัยแล้ว
    $sql_del_event = "DELETE FROM events WHERE event_id = ?";
    $stmt_del_event = $conn->prepare($sql_del_event);
    $stmt_del_event->bind_param('i', $event_id);
    
    return $stmt_del_event->execute();
}

function createEvent($user_id, $title, $description, $location, $start_date, $end_date): int|bool
{
    global $conn;
    
    // คำสั่ง SQL สำหรับเพิ่มข้อมูลใหม่
    $sql = "INSERT INTO events (user_id, title, description, location, start_date, end_date) 
            VALUES (?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    // isssss หมายถึง: Integer 1 ตัว (user_id) และ String 5 ตัว
    $stmt->bind_param('isssss', $user_id, $title, $description, $location, $start_date, $end_date);
    
    if ($stmt->execute()) {
        // คืนค่า ID ของกิจกรรมที่เพิ่งสร้างเสร็จ (เผื่อเอาไปใช้ต่อ เช่น อัปโหลดรูป)
        return $conn->insert_id; 
    }
    return false;
}

function addEventImage(int $event_id, string $image_path): bool
{
    global $conn;
    $sql = "INSERT INTO event_images (event_id, image_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $event_id, $image_path);
    return $stmt->execute();
}