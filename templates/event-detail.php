<html>

<head></head>

<body>
    <?php include 'headermain.php' ?>
    <main style="padding: 20px;">
        <?php
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
           
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_id']):
            ?>
                <div class="actions" style="margin-top: 10px; display: flex; gap: 10px;">
                    <a href="/edit-event?id=<?= $event['event_id'] ?>" style="color: blue;">แก้ไขกิจกรรม</a>

                    <a href="/delete-event?id=<?= $event['event_id'] ?>" 
                       style="color: red;" 
                       onclick="return confirm('ลบไหม?')">ลบกิจกรรม</a>
                </div>

            <?php else: ?>
                <form action="/join-event" method="post" style="margin-top: 15px;">
                    <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                    <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        ขอเข้าร่วมกิจกรรม
                    </button>
                </form>
            <?php endif; // ปิดเงื่อนไขเช็คเจ้าของกิจกรรม ?>

        <?php else: ?>
            <p style="color: red;">ไม่พบข้อมูลกิจกรรม</p>
        <?php endif; // ปิดเงื่อนไขเช็คว่ามีข้อมูล $event ไหม ?>

    </main>
    <?php include 'footer.php' ?>
</body>

</html>