<html>

<head>

</head>

<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <main style="padding: 20px;">
        <h1><?= $data['title'] ?></h1>

        <div style="margin-bottom: 20px;">
            <a href="?status=all">[ ทั้งหมด ]</a> |
            <a href="?status=approved">[ อนุมัติแล้ว ]</a> |
            <a href="?status=pending">[ รออนุมัติ ]</a> |
            <a href="?status=rejected">[ ถูกปฏิเสธ ]</a>
        </div>

        <hr>

        <div class="events">
            <?php
            // เช็คว่ามีข้อมูลกิจกรรมไหม
            if ($data['result']->num_rows > 0):
                // วนลูปแสดงทีละอัน
                while ($row = $data['result']->fetch_assoc()):
            ?>
                    <div style="border: 1px solid #000; padding: 10px; margin-bottom: 10px; width: 300px; display: inline-block; vertical-align: top;">

                        <img src="<?= $row['image_path'] ?>" alt="รูปภาพกิจกรรม" style="width: 100%; height: auto;">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p>ผู้จัด: <?= htmlspecialchars($row['creator_name']) ?></p>
                        <p>วันที่เริ่ม: <?= date('d M Y', strtotime($row['start_date'])) ?></p>

                        <p>สถานะ:
                            <strong>
                                <?php
                                if ($row['join_status'] == 'approved') echo "✅ อนุมัติแล้ว";
                                elseif ($row['join_status'] == 'pending') echo "⏳ รออนุมัติ";
                                elseif ($row['join_status'] == 'rejected') echo "❌ ถูกปฏิเสธ";
                                ?>
                            </strong>
                        </p>

                        <a href="/event-detail?id=<?= $row['event_id'] ?>">ดูรายละเอียดกิจกรรม</a>

                    </div>
                <?php
                endwhile;
            else:
                ?>
                <p>ไม่พบกิจกรรมในหมวดหมู่นี้</p>
            <?php endif; ?>
        </div>

    </main>
    <footer>
        <?php include 'footer.php' ?>
    </footer>
</body>

</html>