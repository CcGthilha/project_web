<?php
if (!$_GET['id']) {
    echo "<script>alert('กรุณาล็อกอินก่อนสร้างกิจกรรม'); 
        window.location.href='/login';</script>";
    exit();
}

$event_id = (int)$_GET['id'];
$res = getEventsById($event_id);
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