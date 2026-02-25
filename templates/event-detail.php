<html>

<head></head>

<body>
    <?php include 'header.php' ?>
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
            // ถ้าไม่ใช่เจ้าของกิจกรรม และล็อกอินอยู่
            elseif (isset($_SESSION['user_id'])):

                // 1. เรียกใช้ฟังก์ชันใหม่ที่เราเพิ่งสร้างเพื่อดึงสถานะมา
                $reg_status = getRegistrationStatus($_SESSION['user_id'], $event['event_id']);

                // 2. เช็คสถานะแล้วแสดงข้อความให้ตรงความจริง
                if ($reg_status === 'pending'):
                ?>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
                        <p style="color: orange; font-weight: bold; margin: 0;">⏳ คำขอของคุณกำลังรอการอนุมัติ</p>

                        <form action="/cancel-join" method="post" style="margin: 0;">
                            <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                            <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;" onclick="return confirm('แน่ใจหรือไม่ว่าต้องการยกเลิกคำขอเข้าร่วม?')">ยกเลิกคำขอ</button>
                        </form>
                    </div>
                <?php elseif ($reg_status === 'approved'): ?>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
                        <p style="color: green; font-weight: bold; margin: 0;">✅ อนุมัติให้เข้าร่วมกิจกรรมแล้ว!</p>

                        <form action="/cancel-join" method="post" style="margin: 0;">
                            <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                            <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;" onclick="return confirm('แน่ใจหรือไม่ว่าต้องการออกจากการเข้าร่วมกิจกรรมนี้?')">ออกจากการเข้าร่วม</button>
                        </form>
                    </div>
                <?php elseif ($reg_status === 'rejected'): ?>
                    <p style="color: red; font-weight: bold; margin-top: 15px;">❌ ขออภัย คำขอเข้าร่วมของคุณถูกปฏิเสธ</p>
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