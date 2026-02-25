<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <header>
        <?php include 'header.php' ?>
    </header>

    <main style="padding: 20px;">
        <h1><?= $data['title'] ?></h1>

        <?php
        
        if (isset($data['event'])):
            // เอาข้อมูลมาใส่ตัวแปร $row เพื่อให้เรียกใช้โค้ดเดิมด้านล่างได้เลย
            $row = $data['event'];
        ?>
            <?php $row = $data['event']; ?>
            <form action="/edit-event" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; max-width: 500px; gap: 10px;">
                <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">

                <label>รูปภาพปัจจุบัน:</label>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px;">
                    <?php if (!empty($data['images'])): ?>
                        <?php foreach ($data['images'] as $img_id => $img_path): ?>
                            <div style="text-align: center;">
                                <img src="<?= $img_path ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                <br>
                                <input type="checkbox" name="delete_images[]" value="<?= $img_id ?>"> ลบ
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <label for="new_images">เพิ่มรูปภาพเพิ่มเติม:</label>
                <input type="file" name="new_images[]" accept="image/*" multiple>

                <label for="title">ชื่อกิจกรรม:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>

                <label for="description">รายละเอียด:</label>
                <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($row['description']) ?></textarea>

                <label for="location">สถานที่:</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($row['location']) ?>" required>

                <label for="start_date">เริ่มวันที่:</label>
                <input type="datetime-local" id="start_date" name="start_date"
                    value="<?= date('Y-m-d\TH:i', strtotime($row['start_date'])) ?>" required>

                <label for="end_date">สิ้นสุดวันที่:</label>
                <input type="datetime-local" id="end_date" name="end_date"
                    value="<?= date('Y-m-d\TH:i', strtotime($row['end_date'])) ?>" required>

                <button type="submit" style="margin-top: 15px; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                    บันทึกการแก้ไข
                </button>
            </form>
        <?php else: ?>
            <p style="color: red;">ไม่พบข้อมูลกิจกรรมที่ต้องการแก้ไข หรือคุณไม่มีสิทธิ์เข้าถึง</p>
        <?php endif; ?>

    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>
</body>

</html>