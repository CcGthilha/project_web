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

    // 🌟 1. จัดการเรื่องจำนวนผู้เข้าร่วมสูงสุด (ดักจับคนปรับลดเกินเหตุ) 🌟
    $max_participants = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;
    if ($max_participants > 99999) {
        $max_participants = 99999;
    }

    $current_joined = getParticipantCount($event_id);

    if ($max_participants > 0 && $max_participants < $current_joined) {
        echo "<script>
                alert('❌ ไม่สามารถแก้ไขได้! จำนวนรับสูงสุดต้องไม่น้อยกว่าผู้เข้าร่วมปัจจุบัน ($current_joined คน)'); 
                window.history.back();
              </script>";
        exit();
    }


    $final_description = trim($_POST['description']) . " [MAX:" . $max_participants . "]";

    // 1. ลบรูปที่ผู้ใช้ติ๊กเลือก
    if (isset($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $image_id) {
            deleteImageById((int)$image_id);
        }
    }

    // 2. อัปโหลดรูปใหม่เพิ่มเติม
    if (isset($_FILES['new_images']) && !empty($_FILES['new_images']['name'][0])) {
        // 🌟 แก้บรรทัดนี้: เพิ่ม __DIR__ ให้มันหาโฟลเดอร์ public เจอชัวร์ๆ
        $upload_dir = __DIR__ . '/../public/uploads/'; 
        
        // เช็คว่ามีโฟลเดอร์ไหม ถ้าไม่มีให้สร้าง (กันเหนียว)
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['new_images']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = time() . '_edit_' . $key . '_' . basename($_FILES['new_images']['name'][$key]);
                if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
                    // 🌟 แก้บรรทัดนี้: เติม /public นำหน้า path ที่จะเซฟลงฐานข้อมูล
                    addEventImage($event_id, '/public/uploads/' . $file_name);
                }
            }
        }
    }

    // 3. อัปเดตข้อมูลตัวอักษร
    updateEvent($event_id, $_POST['title'], $final_description, $_POST['location'], $_POST['start_date'], $_POST['end_date']);
    header('Location: /events');
    exit();
}