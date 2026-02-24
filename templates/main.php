<html>
<head></head>
<body>
    <?php include 'headermain.php' ?>
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
                        // ตรวจสอบเงื่อนไขปุ่มเข้าร่วม
                        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): 
                            if (isAlreadyJoined($_SESSION['user_id'], $row['event_id'])): 
                        ?>
                                <p>คุณได้ขอเข้าร่วมกิจกรรมนี้แล้ว</p>
                            <?php else: ?>
                                <form action="join-event" method="post">
                                    <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                                    <button type="submit" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px;">เข้าร่วมกิจกรรม</button>
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