<?php
session_start();

// ล้างค่าตัวแปร Session ทั้งหมด
session_unset();

// ทำลาย Session ทิ้งอย่างถาวร
session_destroy();

// เด้งกลับไปที่หน้าแรกสุด (หน้าดูกิจกรรม)
header('Location: /');
exit();
?>