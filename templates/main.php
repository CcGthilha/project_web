<html>

<body>
    <?php include 'header.php' ?>

    <main style="padding: 20px; max-width:1200px; margin:0 auto;">

        <a href="/create-event" style="display:inline-block; margin-bottom:15px;">
            + เพิ่มกิจกรรมของคุณ
        </a>

        <!-- ฟิลเตอร์ค้นหา -->
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin-bottom:25px;">
            <form action="search" method="get" style="display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end;">
                <div>
                    <label>ค้นหาด้วยชื่อกิจกรรม:</label><br>
                    <input type="text" name="keyword"
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                        placeholder="พิมพ์ชื่อกิจกรรม...">
                </div>
                <div>
                    <label>จากวันที่:</label><br>
                    <input type="date" name="start_date"
                        value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
                </div>
                <div>
                    <label>ถึงวันที่:</label><br>
                    <input type="date" name="end_date"
                        value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
                </div>

                <button type="submit"
                    style="background:#007bff; color:white; border:none; padding:8px 15px; border-radius:4px; cursor:pointer;">
                    ค้นหา
                </button>

                <?php if (!empty($_GET['keyword']) || !empty($_GET['start_date'])): ?>
                    <a href="/main"
                        style="color:#666; font-size:0.9rem; text-decoration:none; border:1px solid #ccc;
                        padding:7px 12px; border-radius:4px; background:#fff;">
                        ล้างการค้นหา
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- กิจกรรมที่กำลังจะมาถึง -->
        <h1 style="margin-top:10px; margin-bottom:15px;">กิจกรรมที่กำลังจะมาถึง</h1>

        <div style="display:flex; flex-wrap:wrap; gap:20px;">

            <?php
            $res_upcoming = $data['upcoming'];
            if ($res_upcoming && $res_upcoming->num_rows > 0):
                while ($row = $res_upcoming->fetch_assoc()):
            ?>

                    <div style="width:260px; border:1px solid #ccc; border-radius:10px; padding:15px; background:white;
        display:flex; flex-direction:column;">

                        <img src="<?= $row['image_path'] ?: '/public/default.jpg' ?>"
                            style="width:100%; height:160px; object-fit:cover; border-radius:8px;">

                        <h2 style="font-size:1.1rem; margin:10px 0;"><?= htmlspecialchars($row['title']) ?></h2>

                        <p style="font-size:0.9rem; color:#555;">โดย: <?= htmlspecialchars($row['name']) ?></p>

                        <p>📅 <?= date('j M Y - H:i', strtotime($row['start_date'])) ?> น.</p>

                        <button onclick="location.href='event-detail?event_id=<?= $row['event_id'] ?>'"
                            style="margin-top:10px; padding:8px; cursor:pointer; background:#eee; border-radius:5px;">
                            ดูรายละเอียด
                        </button>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): ?>

                            <?php $reg_status = getRegistrationStatus($_SESSION['user_id'], $row['event_id']); ?>

                            <div style="margin-top:10px; text-align:center;">

                                <?php if ($reg_status === 'pending'): ?>
                                    <span style="color:orange; font-weight:bold;">⏳ รอการอนุมัติ</span>

                                <?php elseif ($reg_status === 'approved'): ?>
                                    <span style="color:green; font-weight:bold;">✅ อนุมัติแล้ว</span>

                                <?php elseif ($reg_status === 'attended'): ?>
                                    <span style="color:#28a745; font-weight:bold;">🎉 เข้าร่วมแล้ว</span>

                                <?php elseif ($reg_status === 'rejected'): ?>
                                    <span style="color:red; font-weight:bold;">❌ ถูกปฏิเสธ</span>

                                <?php else: ?>
                                    <!-- ปุ่มเข้าร่วม -->
                                    <form action="/join-event" method="post">
                                        <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                                        <button type="submit"
                                            style="background:#28a745; color:white; border:none; padding:8px; width:100%; border-radius:5px; cursor:pointer;">
                                            เข้าร่วมกิจกรรม
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </div>

                        <?php endif; ?>

                    </div>

                <?php
                endwhile;
            else:
                ?>

                <div style="width:100%; text-align:center; padding:40px; background:#fafafa; border-radius:10px;">
                    <h3 style="color:#999;">ไม่มีรายการกิจกรรมที่กำลังจะมาถึง</h3>
                </div>

            <?php endif; ?>

        </div>


        <!-- กิจกรรมที่จบลงแล้ว -->
        <h1 style="margin-top:40px; margin-bottom:15px;">กิจกรรมที่จบลงแล้ว</h1>

        <div style="display:flex; flex-wrap:wrap; gap:20px;">

            <?php
            $res_past = $data['past'];   // เพิ่มตัวแปรใน controller
            if ($res_past && $res_past->num_rows > 0):
                while ($row = $res_past->fetch_assoc()):
            ?>

                    <div style="width:260px; border:1px solid #ddd; border-radius:10px; padding:15px; background:#f7f7f7;
            opacity:0.85; display:flex; flex-direction:column;">

                        <img src="<?= $row['image_path'] ?: '/public/default.jpg' ?>"
                            style="width:100%; height:160px; object-fit:cover; border-radius:8px; filter:grayscale(70%);">

                        <h2 style="font-size:1.1rem; margin:10px 0;">
                            <?= htmlspecialchars($row['title']) ?>
                        </h2>

                        <p style="font-size:0.9rem; color:#555;">
                            โดย: <?= htmlspecialchars($row['name']) ?>
                        </p>

                        <p>⏳ จบเมื่อ: <?= date('j M Y - H:i', strtotime($row['end_date'])) ?> น.</p>

                        <button onclick="location.href='event-detail?event_id=<?= $row['event_id'] ?>'"
                            style="margin-top:auto; padding:8px; cursor:pointer; background:#ddd; border-radius:5px;">
                            ดูรายละเอียดกิจกรรม
                        </button>

                    </div>

                <?php endwhile;
            else: ?>

                <div style="width:100%; text-align:center; padding:40px; background:#fafafa; border-radius:10px;">
                    <h3 style="color:#999;">ยังไม่มีกิจกรรมที่ผ่านมาบันทึกไว้</h3>
                </div>

            <?php endif; ?>

        </div>

    </main>

    <?php include 'footer.php' ?>
</body>

</html>