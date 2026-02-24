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
            <div class="events" style="display: flex;">
                <?php do { ?>
                    <div class="event " style="display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <h2><?php echo $row['title']; ?></h2>

                        <img src="<?= $row['image_path'] ?: 'path/to/default-image.jpg' ?>" alt="<?= $row['title'] ?>" style="width: 200px; height: auto;">
                        <p>จัดโดย: <?= $row['name']; ?></p>
                        <p>รายละเอียด: <?= $row['description']; ?></p>
                        <p>สถานที่: <?= $row['location']; ?></p>
                        <p>เริ่มวันที่: <?= $row['start_date']; ?></p>
                        <p>สิ้นสุดวันที่: <?= $row['end_date']; ?></p>
                        <?php
                        // เช็คสิทธิ์และแสดงปุ่ม โดยใช้ตัวแปร $row (แก้กลับให้ถูกต้องแล้ว)
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']):
                        ?>
                            <div class="actions" style="margin-top: auto; padding-top: 15px; display: flex; gap: 10px; border-top: 1px solid #eee;">
                                <a href="/edit-event?id=<?= $row['event_id'] ?>" style="color: blue; text-decoration: none;">แก้ไข</a>

                                <a href="/delete-event?id=<?= $row['event_id'] ?>" style="color: red;" onclick="return confirm('ลบกิจกรรมนี้ไหม?')">ลบ</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php } while ($row = $data['result']->fetch_assoc()); // ดึงข้อมูลถัดไปจนกว่าจะหมด 
                ?>
            </div>
        <?php else: ?>
            <h1>ไม่พบกิจกรรม</h1>
        <?php endif; ?>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>