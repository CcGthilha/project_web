<html>
<head></head>
<body>
    <?php include 'headermain.php' ?>
    <main>
        <?php
        // ลบบรรทัดที่ fetch เดิมออก เพราะเรา fetch มาจาก Route แล้ว
        // ดึงค่าจาก $data['event'] ที่ส่งมาจาก renderView ใน Route
        $event = $data['event']; 
        ?>

        <h1><?= $data['title'] ?></h1>
        
        <div class="image-gallery" style="display: flex; gap: 10px; overflow-x: auto; margin-bottom: 20px;">
            <?php if (!empty($data['images'])): ?>
                <?php foreach ($data['images'] as $img): ?>
                    <img src="<?= $img ?>" style="width: 300px; height: auto; border-radius: 8px;">
                <?php endforeach; ?>
            <?php else: ?>
                <p>ไม่มีรูปภาพประกอบ</p>
            <?php endif; ?>
        </div>

        <?php if ($event): ?>
            <p>ชื่อกิจกรรม: <?= $event['title'] ?></p>
            <p>รายละเอียด: <?= $event['description'] ?></p>
            <p>สถานที่: <?= $event['location'] ?></p>
            <p>เริ่มวันที่: <?= date('F j, Y', strtotime($event['start_date'])) ?></p>
            <p>สิ้นสุดวันที่: <?= date('F j, Y', strtotime($event['end_date'])) ?></p>
        <?php else: ?>
            <p>ไม่พบข้อมูลกิจกรรม</p>
        <?php endif; ?>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>