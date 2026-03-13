<?php
// routes/edit-event.php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $event_id = $_GET['id'] ?? 0;
    $result = getEventByEventId($event_id);
    $images = [];
    $event_data = null;

    while ($row = $result->fetch_assoc()) {
        if (!$event_data) $event_data = $row;
        if (isset($row['image_id']) && $row['image_id']) {
            $images[$row['image_id']] = $row['image_path'];
        }
    }

    if (!$event_data || $event_data['user_id'] != $_SESSION['user_id']) {
        // ใช้ SESSION สำหรับแจ้งเตือนข้อผิดพลาด
        $_SESSION['msg_error'] = 'คุณไม่มีสิทธิ์เข้าถึงกิจกรรมนี้';
        header('Location: /main');
        exit();
    }

    renderView('edit-event', [
        'title' => 'แก้ไขกิจกรรม',
        'event' => $event_data,
        'images' => $images
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];

    // 🌟 1. จัดการเรื่องจำนวนผู้เข้าร่วมสูงสุด (คงเดิม)
    $max_participants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;
    if ($max_participants > 99999) {
        $max_participants = 99999;
    }

    $current_joined = getParticipantCount($event_id);

    if ($max_participants > 0 && $max_participants < $current_joined) {
        $_SESSION['msg_error'] = "ไม่สามารถแก้ไขได้! จำนวนรับสูงสุดต้องไม่น้อยกว่าผู้เข้าร่วมปัจจุบัน ($current_joined คน)";
        header("Location: /edit-event?id=$event_id");
        exit();
    }

    $final_description = trim($_POST['description']) . " [MAX:" . $max_participants . "]";

    // 🌟 2. แก้ไขส่วนการลบรูปภาพ: เพิ่มการเช็คจำนวนรูปขั้นต่ำ
    if (isset($_POST['delete_images'])) {
        $delete_ids = $_POST['delete_images'];

        // ดึงจำนวนรูปภาพปัจจุบันทั้งหมดของกิจกรรมนี้จากฐานข้อมูล
        $current_images_res = getEventByEventId($event_id);
        $total_current_images = $current_images_res->num_rows;

        // ตรวจสอบว่าถ้าลบตามที่เลือกแล้ว จะยังเหลืออย่างน้อย 1 รูปหรือไม่
        if (($total_current_images - count($delete_ids)) >= 1) {
            foreach ($delete_ids as $image_id) {
                deleteImageById((int)$image_id); // เรียกฟังก์ชันลบรูป
            }
        } else {
            // หากผู้ใช้พยายามลบจนไม่เหลือรูปเลย ให้เก็บข้อความแจ้งเตือนความผิดพลาด
            $_SESSION['msg_error'] = 'ไม่สามารถลบได้ กิจกรรมต้องมีรูปภาพแสดงอย่างน้อย 1 รูป';
            header("Location: /edit-event?id=$event_id");
            exit();
        }
    }

    // 3. อัปโหลดรูปใหม่เพิ่มเติม (คงเดิม)
    if (isset($_FILES['new_images']) && !empty($_FILES['new_images']['name'][0])) {
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['new_images']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = time() . '_edit_' . $key . '_' . basename($_FILES['new_images']['name'][$key]);
                if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
                    addEventImage($event_id, '/public/uploads/' . $file_name);
                }
            }
        }
    }

    // 4. อัปเดตข้อมูลตัวอักษร (คงเดิม)
    $update_res = updateEvent($event_id, $_POST['title'], $final_description, $_POST['location'], $_POST['start_date'], $_POST['end_date']);

    if ($update_res) {
        $_SESSION['msg_success'] = 'แก้ไขข้อมูลกิจกรรมเรียบร้อยแล้ว!';
    } else {
        $_SESSION['msg_error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล';
    }

    header('Location: /events');
    exit();
}
