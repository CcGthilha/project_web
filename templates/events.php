<html>

<head></head>

<body>
    <?php include 'headermain.php' ?>
    <main>
        <?php
        $row = $data['result']->fetch_assoc();
        if ($row): // ตรวจสอบว่ามีข้อมูลใน $row หรือไม่
        ?>
            <h1>กิจกรรม</h1>
            <div class="events" style="display: flex;">
                <?php do { ?>
                    <div class="event " style="display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <h2><?php echo $row['title']; ?></h2>
                        <img src="<?= $row['image_path'] ?>" alt="asfsf" style="width: 200px; height: auto;">
                        <p>จัดโดย: <?= $row['name']; ?></p>
                        <p>รายละเอียด: <?= $row['description']; ?></p>
                        <p>เริ่มวันที่: <?= $row['start_date']; ?></p>
                        <p>สิ้นสุดวันที่: <?= $row['end_date']; ?></p>
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