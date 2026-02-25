<html>

<head>
    <title><?= $data['title'] ?></title>
</head>

<body>
    <?php include 'header.php' ?>
    <main style="padding: 20px;">
        <h1>กิจกรรม</h1>
        <a href="/create-event" style="display: inline-block; margin-bottom: 15px;"> + เพิ่มกิจกรรมของคุณ </a>

        <div style="background: #f4f4f4; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <form action="search" method="get" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;">
                <div>
                    <label>ค้นหาด้วยชื่อกิจกรรม:</label><br>
                    <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="พิมพ์ชื่อกิจกรรม...">
                </div>
                <div>
                    <label>จากวันที่:</label><br>
                    <input type="date" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
                </div>
                <div>
                    <label>ถึงวันที่:</label><br>
                    <input type="date" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
                </div>
                <button type="submit" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">ค้นหา</button>

                <?php if (!empty($_GET['keyword']) || !empty($_GET['start_date'])): ?>
                    <a href="/main" style="color: #666; font-size: 0.9rem; text-decoration: none; border: 1px solid #ccc; padding: 7px 12px; border-radius: 4px; background: #fff;">ล้างการค้นหา</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="events" style="display: flex; flex-wrap: wrap; gap: 15px;">
            <?php
            $res = $data['result'];
            if ($res && $res->num_rows > 0):
                while ($row = $res->fetch_assoc()):
            ?>
                    <div class="event" style="width: 250px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; display: flex; flex-direction: column;">
                        <img src="<?= $row['image_path'] ?: '/path/to/default-image.jpg' ?>"
                            style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">
                        <h2 style="font-size: 1.2rem; margin: 10px 0;"><?= htmlspecialchars($row['title']) ?></h2>
                        <p style="font-size: 0.9rem; color: #555;">โดย: <?= htmlspecialchars($row['name']) ?></p>

                        <p>📅 <?= date('F j, Y - H:i', strtotime($row['start_date'])) ?> น.</p>

                        <button onclick="window.location.href='event-detail?id=<?= $row['event_id'] ?>'"
                            style="margin-top: auto; padding: 8px; cursor: pointer; background: #eee; border: 1px solid #ddd;">
                            ดูรายละเอียด
                        </button>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): ?>
                            <?php $reg_status = getRegistrationStatus($_SESSION['user_id'], $row['event_id']); ?>
                            <div style="margin-top: 10px; text-align: center;">
                                <?php if ($reg_status === 'pending'): ?>
                                    <span style="color: orange; font-weight: bold;">⏳ รอการอนุมัติ</span>
                                <?php elseif ($reg_status === 'approved'): ?>
                                    <span style="color: green; font-weight: bold;">✅ อนุมัติแล้ว</span>
                                <?php elseif ($reg_status === 'rejected'): ?>
                                    <span style="color: red; font-weight: bold;">❌ ถูกปฏิเสธ</span>
                                <?php else: ?>
                                    <form action="/join-event" method="post">
                                        <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; width: 100%;">เข้าร่วมกิจกรรม</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <div style="width: 100%; text-align: center; padding: 80px 20px; border: 2px dashed #ddd; border-radius: 10px; background: #fafafa;">
                    <h2 style="color: #666;">🔍 ไม่พบกิจกรรมที่คุณค้นหา</h2>
                    <p style="color: #999;">ลองเปลี่ยนคำค้นหา หรือขยายช่วงวันที่ให้กว้างขึ้น</p>
                    <a href="/main" style="display: inline-block; margin-top: 20px; color: #007bff; font-weight: bold;">กลับไปดูความเคลื่อนไหวล่าสุด</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>

</html>