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
    $sql = 'select * from events e join users u on e.user_id = u.user_id join event_images ei on e.event_id = ei.event_id where e.user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
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
    $sql = 'select * from events e join users u on e.user_id = u.user_id join event_images ei on e.event_id = ei.event_id where e.event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
