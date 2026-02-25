<?php
$result = [];
$keyword = $_GET['keyword'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';


if ($start_date != '' && $end_date != '') {
    // กรณีค้นหาตามช่วงวัน
    $result = getEventByDateRange($start_date, $end_date);
} elseif ($keyword != '') {
    // กรณีค้นหาตาม Keyword (โค้ดเดิม)
    $result = getEventByKeyword($keyword);
} else {
    // ดึงข้อมูลทั้งหมด (โค้ดเดิม)
    $result = getEvent();
}

renderView('main', ['title' => 'ผลการค้นหา', 'result' => $result]);
