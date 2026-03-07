<?php
if (!$_GET['event_id'] && !isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดูรายละเอียดกิจกรรม'); 
        window.location.href='/login';</script>";
    exit();
}
if (!$_GET['event_id'] ) {
    echo "<script>alert('ไม่พบกิจกรรมนี้ กรุณาสร้างกิจกรรมก่อน'); 
        window.location.href='/events';</script>";
    exit();
}

$event_id = (int)$_GET['event_id'];
$res = getEventByEventId($event_id);
$images = [];
$eventInfo = null;

while ($row = $res->fetch_assoc()) {
    if (!$eventInfo) $eventInfo = $row;
    if ($row['image_path']) $images[] = $row['image_path'];
}

// ดึงรายชื่อคนเข้าร่วม
$participants = getParticipantsByEventId($event_id);

renderView('event-detail', [
    'title' => 'รายละเอียดกิจกรรม', 
    'event' => $eventInfo, 
    'images' => $images,
    'participants' => $participants // ส่งรายชื่อไปที่ View
]);