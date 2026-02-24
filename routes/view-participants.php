<?php
// routes/view-participants.php
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$event_id = (int)$_GET['id'];
$res = getEventsById($event_id);
$event = $res->fetch_assoc();

// เช็คสิทธิ์ว่าเป็นเจ้าของกิจกรรมหรือไม่
if (!$event || $event['user_id'] != $_SESSION['user_id']) {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึง'); window.location.href='/events';</script>";
    exit();
}

$participants = getParticipantsByEventId($event_id);

renderView('view-participants', [
    'title' => 'รายชื่อผู้เข้าร่วม: ' . $event['title'],
    'participants' => $participants
]);