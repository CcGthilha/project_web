<html>
<head></head>
<body>
    <?php include 'headermain.php' ?>
    <main style="padding: 20px;">
        <?php
        // ดึงข้อมูลกิจกรรมจาก $data ที่ส่งมาจาก Route
        $event = $data['event'] ?? null;
        ?>

        <h1><?= htmlspecialchars($data['title']) ?></h1>

        <div class="image-gallery" style="display: flex; gap: 10px; overflow-x: auto; margin-bottom: 20px;">
            <?php if (!empty($data['images'])): ?>
                <?php foreach ($data['images'] as $img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" style="width: 300px; height: auto; border-radius: 8px;">
                <?php endforeach; ?>
            <?php else: ?>
                <p>ไม่มีรูปภาพประกอบ</p>
            <?php endif; ?>
        </div>

        <?php if ($event): ?>
            <p>ชื่อกิจกรรม: <?= htmlspecialchars($event['title']) ?></p>
            <p>รายละเอียด: <?= htmlspecialchars($event['description']) ?></p>
            <p>สถานที่: <?= htmlspecialchars($event['location']) ?></p>
            <p>เริ่มวันที่: <?= date('F j, Y', strtotime($event['start_date'])) ?></p>
            <p>สิ้นสุดวันที่: <?= date('F j, Y', strtotime($event['end_date'])) ?></p>
            
            <?php
            // ตรวจสอบสิทธิ์: ถ้าเป็นเจ้าของกิจกรรม ให้แสดงปุ่มแก้ไข/ลบ
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_id']):
            ?>
                <div class="actions" style="margin-top: 10px; display: flex; gap: 10px;">
                    <a href="/edit-event?id=<?= $event['event_id'] ?>" style="color: blue;">แก้ไขกิจกรรม</a>
                    <a href="/delete-event?id=<?= $event['event_id'] ?>"
                       style="color: red;"
                       onclick="return confirm('ยืนยันการลบกิจกรรมนี้?')">ลบกิจกรรม</a>
                </div>

            <?php 
            // ถ้าไม่ใช่เจ้าของกิจกรรม และเป็นบุคคลทั่วไปที่ล็อกอินแล้ว ให้แสดงปุ่มเข้าร่วม
            elseif (isset($_SESSION['user_id'])): 
                // ตรวจสอบว่าเคยขอเข้าร่วมไปหรือยัง (ใช้ฟังก์ชันที่คุณสร้างไว้)
                if (isAlreadyJoined($_SESSION['user_id'], $event['event_id'])):
            ?>
                    <p style="color: orange; margin-top: 15px;">คุณได้ส่งคำขอเข้าร่วมกิจกรรมนี้แล้ว</p>
                <?php else: ?>
                    <form action="/join-event" method="post" style="margin-top: 15px;">
                        <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                        <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            เข้าร่วมกิจกรรม
                        </button>
                    </form>
                <?php endif; ?>
            
            <?php else: ?>
                <p style="margin-top: 15px;"><a href="/login">เข้าสู่ระบบ</a> เพื่อเข้าร่วมกิจกรรม</p>
            <?php endif; ?>

        <?php else: ?>
            <p style="color: red;">ไม่พบข้อมูลกิจกรรม</p>
        <?php endif; ?>

    </main>
    <?php include 'footer.php' ?>
</body>
</html>