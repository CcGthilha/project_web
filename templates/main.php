<html>

<head></head>

<body>
    <?php include 'header.php' ?>
    <main>
        <?php
        $row = $data['result']->fetch_assoc();
        if ($row):
        ?>
            <h1>กิจกรรม</h1>
            <a href="/create-event" style="display: inline-block; margin-bottom: 15px;"> + เพิ่มกิจกรรมของคุณ </a>

            <form action="search" method="get">
                <input type="text" name="keyword" />
                <button type="submit">Search</button>
            </form>
            <form method="GET" action="search"> <label>จากวันที่:</label>
                <input type="date" name="start_date" required>

                <label>ถึงวันที่:</label>
                <input type="date" name="end_date" required>

                <button type="submit">ค้นหา</button>
            </form>

            <div class="events" style="display: flex; flex-wrap: wrap; gap: 10px;">
                <?php do { ?>
                    <div class="event" style="display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <img src="<?= $row['image_path'] ?: 'path/to/default-image.jpg' ?>"
                            alt="<?= $row['title'] ?>"
                            style="width: 200px; height: auto;">
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <h2><?php echo $row['title']; ?></h2>
                            <h4><?php echo "Create by: " . $row['name']; ?></h4>
                        </div>

                        <p><?= $row['start_date'] ?></p>
                        <button onclick="window.location.href='event-detail?id=<?= $row['event_id'] ?>'">ดูรายละเอียด</button>

                        <?php
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']):
                            // ดึงสถานะปัจจุบันมาเช็ค
                            $reg_status = getRegistrationStatus($_SESSION['user_id'], $row['event_id']);
                            if ($reg_status === 'pending'):
                        ?>
                                <p style="color: orange; font-weight: bold; margin: 0; text-align: center;">⏳ รอการอนุมัติ</p>
                            <?php elseif ($reg_status === 'approved'): ?>
                                <p style="color: green; font-weight: bold; margin: 0; text-align: center;">✅ อนุมัติแล้ว</p>
                            <?php elseif ($reg_status === 'rejected'): ?>
                                <p style="color: red; font-weight: bold; margin: 0; text-align: center;">❌ ถูกปฏิเสธ</p>
                            <?php else: ?>
                                <form action="/join-event" method="post" style="margin: 0; text-align: center;">
                                    <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                                    <button type="submit" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; width: 100%;">เข้าร่วมกิจกรรม</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php } while ($row = $data['result']->fetch_assoc()); ?>
            </div>
        <?php else: ?>
            <h1>ไม่พบกิจกรรม</h1>
        <?php endif; ?>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>