<html>

<head></head>

<body>
    <?php include 'headermain.php' ?>
    <main>
    <?php
    $row = $data['result']->fetch_assoc();
    if ($row): // ตรวจสอบว่ามีข้อมูลใน $row หรือไม่
    ?>
        <h1><?= $data['title'] ?></h1>
        <p>ยินดีต้อนรับคุณ <?= $row['name'] ?></p>
    <?php else: ?>
        <h1>ไม่พบข้อมูลผู้ใช้</h1>
    <?php endif; ?>
</main>
    <?php include 'footer.php' ?>
</body>

</html>