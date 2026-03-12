<?php
$result = [];
$keyword = $_GET['keyword'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

if ($start_date != '' && $end_date != '') {
    $result = getEventByDateRange($start_date, $end_date);
} elseif ($keyword != '') {
    $result = getEventByKeyword($keyword);
} else {
    $result = getUpcomingEvents();
}

// แก้ไขจุดนี้: เปลี่ยนจาก 'result' เป็น 'upcoming'
renderView('main', ['title' => 'ผลการค้นหา', 'upcoming' => $result]);
