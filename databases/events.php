<?php
function getEvent(): mysqli_result|bool
{
    global $conn;
    $sql = 'select e.*, u.name, ei.image_path 
            from events e 
            join users u on e.user_id = u.user_id 
            left join event_images ei on e.event_id = ei.event_id 
            group by e.event_id 
            order by e.event_id';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result();
}
function getEventsByUserId(int $id): mysqli_result|bool
{
    global $conn;
    $sql = 'select e.*, u.name, ei.image_path from events e 
            join users u on e.user_id = u.user_id 
            left join event_images ei on e.event_id = ei.event_id 
            where e.user_id = ?
            group by e.event_id';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getEventByKeyword(string $keyword): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from events e join users u on e.user_id = u.user_id join 
    event_images ei on e.event_id = ei.event_id where e.title like ? or u.name like ? 
    GROUP BY e.event_id';
    $stmt = $conn->prepare($sql);
    $keyword = '%' . $keyword . '%';
    $stmt->bind_param('ss', $keyword, $keyword);
    $res = $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function getEventByEventId(int $id): mysqli_result|bool
{
    global $conn;
    $sql = 'select e.*, u.name, ei.image_path, ei.image_id from events e 
            join users u on e.user_id = u.user_id 
            left join event_images ei on e.event_id = ei.event_id 
            where e.event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateEvent($event_id, $title, $description, $location, $start_date, $end_date): bool
{
    global $conn;
    $sql = "update events SET title = ?, description = ?, location = ?, start_date = ?, end_date = ? WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $title, $description, $location, $start_date, $end_date, $event_id);
    return $stmt->execute();
}

function deleteEvent(int $event_id): bool
{
    global $conn;
    $sql_get_img = "select image_path FROM event_images WHERE event_id = ?";
    $stmt_get_img = $conn->prepare($sql_get_img);
    $stmt_get_img->bind_param('i', $event_id);
    $stmt_get_img->execute();
    $res_img = $stmt_get_img->get_result();

    if ($row_img = $res_img->fetch_assoc()) {
        $file_path = '../public' . $row_img['image_path'];
        if (file_exists($file_path) && !empty($row_img['image_path'])) {
            unlink($file_path); 
        }
    }
    $sql_del_img = "delete from event_images WHERE event_id = ?";
    $stmt_del_img = $conn->prepare($sql_del_img);
    $stmt_del_img->bind_param('i', $event_id);
    $stmt_del_img->execute();
    $sql_del_reg = "delete from registrations WHERE event_id = ?";
    $stmt_del_reg = $conn->prepare($sql_del_reg);
    $stmt_del_reg->bind_param('i', $event_id);
    $stmt_del_reg->execute();
    $sql_del_event = "delete from events WHERE event_id = ?";
    $stmt_del_event = $conn->prepare($sql_del_event);
    $stmt_del_event->bind_param('i', $event_id);
    return $stmt_del_event->execute();
}

function createEvent($user_id, $title, $description, $location, $start_date, $end_date): int|bool
{
    global $conn;
    $sql = "insert into events (user_id, title, description, location, start_date, end_date) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssss', $user_id, $title, $description, $location, $start_date, $end_date);
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    return false;
}

function addEventImage(int $event_id, string $image_path): bool
{
    global $conn;
    $sql = "insert into event_images (event_id, image_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $event_id, $image_path);
    return $stmt->execute();
}

function deleteImageById(int $image_id): bool
{
    global $conn;

    $sql = "select image_path FROM event_images WHERE image_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $image_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $file_path = '../public' . $row['image_path'];
        if (file_exists($file_path)) unlink($file_path);
    }

    $sql_del = "delete FROM event_images WHERE image_id = ?";
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->bind_param('i', $image_id);
    return $stmt_del->execute();
}

function getEventByDateRange(string $start_date, string $end_date): mysqli_result|bool
{
    global $conn;
    $sql = 'select e.*, u.name, ei.image_path 
            from events e 
            join users u on e.user_id = u.user_id 
            left join event_images ei on e.event_id = ei.event_id 
            where e.start_date between ? and ?
            group by e.event_id 
            ORDER BY e.start_date ASC';
    $stmt = $conn->prepare($sql);
    $full_start = $start_date . " 00:00:00";
    $full_end = $end_date . " 23:59:59";
    $stmt->bind_param('ss', $full_start, $full_end);
    $stmt->execute();
    return $stmt->get_result();
}
