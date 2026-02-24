<?php
// บังคับว่าต้องล็อกอินก่อนถึงจะสร้างกิจกรรมได้
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนสร้างกิจกรรม'); window.location.href='/login';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 1. ถ้าแค่กดลิงก์เข้ามาดูหน้าฟอร์ม ให้แสดงหน้า UI
    renderView('create-event', [
        'title' => 'สร้างกิจกรรมใหม่'
    ]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // 1. สร้างกิจกรรมหลักก่อน เพื่อให้ได้ event_id มา
    $new_event_id = createEvent($user_id, $title, $description, $location, $start_date, $end_date);
    
    if ($new_event_id) {
        
        // 2. ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพมาด้วยหรือไม่ และไม่มี Error
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            // กำหนดโฟลเดอร์ที่จะเก็บรูป (สมมติว่าเก็บในโฟลเดอร์ public/uploads)
            $upload_dir = '../public/uploads/'; 
            
            // ถ้ายังไม่มีโฟลเดอร์ uploads ให้สร้างใหม่เลย
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // ตั้งชื่อไฟล์ใหม่ให้ไม่ซ้ำกัน (ใช้เวลาปัจจุบัน + ชื่อไฟล์เดิม)
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = time() . '_' . basename($_FILES['image']['name']);
            $target_file = $upload_dir . $file_name;
            
            // ย้ายไฟล์จาก temp ไปยังโฟลเดอร์ที่เรากำหนด
            if (move_uploaded_file($file_tmp, $target_file)) {
                
                // 3. บันทึกที่อยู่รูปภาพลงฐานข้อมูล (เก็บแค่ /uploads/ชื่อรูป.jpg)
                $db_image_path = '/uploads/' . $file_name;
                addEventImage($new_event_id, $db_image_path);
            }
        }

        // เสร็จแล้วเด้งกลับไปหน้ากิจกรรม
        header('Location: /events');
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการสร้างกิจกรรม'); window.history.back();</script>";
        exit();
    }
}