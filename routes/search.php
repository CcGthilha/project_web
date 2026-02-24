<?php
$result = [];
$keyword = $_GET['keyword'] ?? '';
if ($keyword == '') {    
    // ดึงข้อมูลกิจกรรมทั้งหมด
    $result = getEvent();
}else {
    // ค้นหาข้อมูลกิจกรรมตามคำค้นหา
    $result = getEventByKeyword($keyword);
}
renderView('main', ['title' => 'สวัสดีจ้า', 'result' => $result]);