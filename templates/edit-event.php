<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <header>
        <?php include 'headermain.php' ?>
    </header>
    
    <main style="padding: 20px;">
        <h1><?= $data['title'] ?></h1>

        <?php 
        // เปลี่ยนมาเช็คว่ามีข้อมูลใน $data['event'] ที่ส่งมาหรือไม่
        if (isset($data['event'])): 
            // เอาข้อมูลมาใส่ตัวแปร $row เพื่อให้เรียกใช้โค้ดเดิมด้านล่างได้เลย
            $row = $data['event']; 
        ?>
            <form action="/edit-event" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; max-width: 500px; gap: 10px;">
                
                <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">

                <label for="title">ชื่อกิจกรรม:</label>
                <input type="text" id="title" name="title" value="<?= $row['title'] ?>" required>

                <label for="description">รายละเอียด:</label>
                <textarea id="description" name="description" rows="4" required><?= $row['description'] ?></textarea>

                <label for="location">สถานที่:</label>
                <input type="text" id="location" name="location" value="<?= $row['location'] ?>" required>

                <label for="start_date">เริ่มวันที่:</label>
                <input type="datetime-local" id="start_date" name="start_date" value="<?= $row['start_date'] ?>" required>

                <label for="end_date">สิ้นสุดวันที่:</label>
                <input type="datetime-local" id="end_date" name="end_date" value="<?= $row['end_date'] ?>" required>

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