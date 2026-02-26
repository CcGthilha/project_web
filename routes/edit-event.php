<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $event_id = $_GET['id'] ?? 0;
    $result = getEventsById($event_id);
    $images = [];
    $event_data = null;

    while ($row = $result->fetch_assoc()) {
        if (!$event_data) $event_data = $row;
        if (isset($row['image_id']) && $row['image_id']) {
            $images[$row['image_id']] = $row['image_path'];
        }
    }

    if (!$event_data || $event_data['user_id'] != $_SESSION['user_id']) {
        echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงกิจกรรมนี้'); window.location.href='/main';</script>";
        exit();
    }

    renderView('edit-event', [
        'title' => 'แก้ไขกิจกรรม',
        'event' => $event_data,
        'images' => $images
    ]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];

    // 1. ลบรูปที่ผู้ใช้ติ๊กเลือก
    if (isset($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $image_id) {
            deleteImageById((int)$image_id);
        }
    }

    // 2. อัปโหลดรูปใหม่เพิ่มเติม
    if (isset($_FILES['new_images']) && !empty($_FILES['new_images']['name'][0])) {
        $upload_dir = '../public/uploads/';
        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['new_images']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = time() . '_edit_' . $key . '_' . basename($_FILES['new_images']['name'][$key]);
                if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
                    addEventImage($event_id, '/uploads/' . $file_name);
                }
            }
        }
    }

    // 3. อัปเดตข้อมูลตัวอักษร
    updateEvent($event_id, $_POST['title'], $_POST['description'], $_POST['location'], $_POST['start_date'], $_POST['end_date']);
    header('Location: /events');
    exit();
}