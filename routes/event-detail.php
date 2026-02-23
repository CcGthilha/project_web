<?php
$res = getEventsById($_GET['id']);
$images = [];
$eventInfo = null;

while ($row = $res->fetch_assoc()) {
    if (!$eventInfo) {
        $eventInfo = $row; // เก็บข้อมูลกิจกรรม (ชื่อ, สถานที่) ไว้แค่ชุดเดียว
    }
    if ($row['image_path']) {
        $images[] = $row['image_path']; // เก็บรูปภาพทั้งหมดลงใน Array
    }
}

renderView('event-detail', [
    'title' => 'รายละเอียดกิจกรรม', 
    'event' => $eventInfo, 
    'images' => $images
]);