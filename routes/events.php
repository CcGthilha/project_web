<?php
// ดึงกิจกรรมทั้งหมดของผู้ใช้ที่ล็อกอินอยู่
$res = getEventById($_SESSION['user_id']); 
$events_with_participants = [];

while ($row = $res->fetch_assoc()) {
    $event_id = $row['event_id'];
    // ดึงรายชื่อคนเข้าร่วมของกิจกรรมนี้ (ใช้ฟังก์ชันที่สร้างไว้ใน databases/events.php)
    $participants_res = getParticipantsByEventId($event_id);
    $participants = [];
    while ($p = $participants_res->fetch_assoc()) {
        $participants[] = $p;
    }
    
    // เก็บข้อมูลกิจกรรมและรายชื่อคนเข้าร่วมไว้ด้วยกัน
    $row['participants'] = $participants;
    $events_with_participants[] = $row;
}

renderView('events', [
    'title' => 'กิจกรรมของคุณ',
    'events' => $events_with_participants
]);