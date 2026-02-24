<?php
// บังคับว่าต้องล็อกอินก่อนถึงจะสร้างกิจกรรมได้
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนสร้างกิจกรรม'); window.location.href='/login';</script>";
    exit();
}

// ตรวจสอบวิธีการร้องขอ
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 1. ถ้าเป็นการเข้าถึงปกติ ให้แสดงหน้าฟอร์มสร้างกิจกรรม
    renderView('create-event', [
        'title' => 'สร้างกิจกรรมใหม่'
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. ถ้าเป็นการส่งข้อมูลจากฟอร์ม
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // สร้างกิจกรรมหลักในฐานข้อมูล
    $new_event_id = createEvent($user_id, $title, $description, $location, $start_date, $end_date);
    
    if ($new_event_id) {
        $upload_dir = '../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // จัดการ "รูปปก" (cover_image)
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $file_name = time() . '_cover_' . basename($_FILES['cover_image']['name']);
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $upload_dir . $file_name)) {
                addEventImage($new_event_id, '/uploads/' . $file_name);
            }
        }

        // จัดการ "รูปเพิ่มเติม" (gallery_images)
        if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
            foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                    $file_name = time() . '_gallery_' . $key . '_' . basename($_FILES['gallery_images']['name'][$key]);
                    if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
                        addEventImage($new_event_id, '/uploads/' . $file_name);
                    }
                }
            }
        }

        header('Location: /events');
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการสร้างกิจกรรม'); window.history.back();</script>";
        exit();
    }
}