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
            <form action="search" method="get">
                <input type="text" name="keyword" />
                <button type="submit">Search</button>
            </form>
            <div class="events" style="display: flex;">
                <?php do { ?>
                    <div class="event " style="display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <img src="<?= $row['image_path'] ?: 'path/to/default-image.jpg' ?>" alt="<?= $row['title'] ?>" style="width: 200px; height: auto;">
                        <h2><?php echo $row['title']; ?></h2>
                        <p><?= $row['start_date'] ?></p>
                        <button onclick="window.location.href='event-detail?id=<?= $row['event_id'] ?>'">ดูรายละเอียด</button>
                        <form action="join-event" method="post">
                            <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                            <button type="submit">เข้าร่วมกิจกรรม</button>
                        </form>
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