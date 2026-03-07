<?php
// routes/event-stats.php
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$event_id = (int)$_GET['id'];
$res = getEventByEventId($event_id);
$event = $res->fetch_assoc();

// เช็คสิทธิ์เจ้าของกิจกรรม
if (!$event || $event['user_id'] != $_SESSION['user_id']) {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึง'); window.location.href='/events';</script>";
    exit();
}

$participants = getParticipantsByEventId($event_id);

renderView('event-stats', [
    'title' => 'สถิติผู้เข้าร่วม: ' . $event['title'],
    'event' => $event,
    'participants' => $participants
]);