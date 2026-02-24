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

        <form action="/create-event" method="POST" style="display: flex; flex-direction: column; max-width: 500px; gap: 10px;" 
        enctype="multipart/form-data">
            <label for="image">รูปภาพหน้าปกกิจกรรม (ถ้ามี):</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label for="title">ชื่อกิจกรรม:</label>
            <input type="text" id="title" name="title" placeholder="ใส่ชื่อกิจกรรมของคุณ" required>

            <label for="description">รายละเอียด:</label>
            <textarea id="description" name="description" rows="4" placeholder="อธิบายเกี่ยวกับกิจกรรมนี้..." required></textarea>

            <label for="location">สถานที่:</label>
            <input type="text" id="location" name="location" placeholder="เช่น อาคาร A ห้อง 101" required>

            <label for="start_date">เริ่มวันที่:</label>
            <input type="datetime-local" id="start_date" name="start_date" required>

            <label for="end_date">สิ้นสุดวันที่:</label>
            <input type="datetime-local" id="end_date" name="end_date" required>

            <button type="submit" style="margin-top: 15px; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                + สร้างกิจกรรม
            </button>
        </form>

    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>
</body>

</html>