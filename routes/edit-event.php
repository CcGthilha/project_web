<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $event_id = $_GET['id'] ?? 0;
    
    // ดึงข้อมูลกิจกรรม
    $result = getEventsById($event_id);
    $event_data = $result->fetch_assoc();

    // เช็คความปลอดภัย
    if (!$event_data || $event_data['user_id'] != $_SESSION['user_id']) {
        echo "<script>alert('คุณไม่มีสิทธิ์แก้ไขกิจกรรมนี้'); window.location.href='/events';</script>";
        exit();
    }

    // ** ส่งข้อมูลผ่าน renderView แทนการ require **
    renderView('edit-event', [
        'title' => 'แก้ไขกิจกรรม',
        'event' => $event_data // ส่งข้อมูลกิจกรรมที่ดึงมาได้ ไปในชื่อ 'event'
    ]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // กรณีผู้ใช้แก้ไขข้อมูลเสร็จแล้วกด "บันทึก"
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $result = getEventsById($event_id);
    $event_data = $result->fetch_assoc();
    
    if ($event_data['user_id'] == $_SESSION['user_id']) {
        updateEvent($event_id, $title, $description, $location, $start_date, $end_date);
        header('Location: /events');
        exit();
    }
}
?>