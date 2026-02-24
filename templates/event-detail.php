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
            <?php
            // ()ตรวจสอบว่า user ที่ล็อกอินอยู่เป็นเจ้าของกิจกรรมหรือไม่
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_id']):
            ?>

                <div class="actions" style="margin-top: 10px; display: flex; gap: 10px;">
                    <a href="/edit-event?id=<?= $event['event_id'] ?>" style="color: blue;">แก้ไขกิจกรรม</a>

                    <a href="/delete-event?id=<?= $event['event_id'] ?>" 
                    style="color: red;" 
                    onclick="return confirm('ลบไหม?')">ลบกิจกรรม</a>
                </div>

            <?php endif; ?>
            <!-- เพิ่มปุ่มเข้าร่วมกิจกรรม -->
        <?php else: ?>
            <p>ไม่พบข้อมูลกิจกรรม</p>
        <?php endif; ?>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>