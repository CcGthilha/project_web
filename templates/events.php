<html>

<head></head>

<body>
    <?php include 'header.php' ?>
    <main>
        <h1><?= $data['title'] ?></h1>
        <div class="events" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; justify-content: center;">
            <?php if (!empty($data['events'])): ?>
                <?php foreach ($data['events'] as $event): ?>
                    <div class="event" style="border: 1px solid #ccc; padding: 15px; width: 300px;">
                        <h2><?= htmlspecialchars($event['title']) ?></h2>
                        <img src="<?= $event['image_path'] ?: 'path/to/default.jpg' ?>" style="width: 100%;">

                        <p><strong>สถานที่:</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <p><strong>วันที่:</strong> <?= date('F j, Y', strtotime($event['start_date'])) ?></p>

                        <div class="actions" style="margin-top: 15px; display: flex; gap: 10px;">
                            <a href="/view-participants?id=<?= $event['event_id'] ?>"
                                style="background-color: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;">
                                ดูรายชื่อผู้ขอเข้าร่วม
                            </a>

                            <a href="/edit-event?id=<?= $event['event_id'] ?>" style="color: blue;">แก้ไข</a>
                            <a href="/delete-event?id=<?= $event['event_id'] ?>" style="color: red;" onclick="return confirm('ลบกิจกรรมนี้?')">ลบ</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 50px;">
                    <p>ยังไม่มีกิจกรรมที่คุณสร้างไว้</p>
                    <h3>สามารถสร้างกิจกรรมของคุณได้ที่นี่</h3>
                    <a href="/create-event">+ เพิ่มกิจกรรมของคุณ</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>