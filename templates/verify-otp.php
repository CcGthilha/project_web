<!-- templates/verify-otp.php -->
<?php include 'header.php'; ?>

<main style="padding: 40px 20px; text-align: center; font-family: sans-serif;">
    
    <?php if (isset($data['title'])): ?>
        <h2 style="color: #333;"><?= htmlspecialchars($data['title']) ?></h2>
    <?php else: ?>
        <h2 style="color: #333;">ตรวจสอบและยืนยันการเข้างาน</h2> <?php endif; ?>

    <p style="color: #666; margin-bottom: 20px;">สำหรับผู้จัด: กรุณากรอกรหัส OTP 6 หลัก จากมือถือของผู้เข้าร่วมกิจกรรม</p>

    <form action="/verify-otp" method="POST" style="max-width: 400px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid #ddd;">

        <?php if (isset($data['event_id'])): ?>
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($data['event_id']) ?>">
        <?php else: ?>
            <p style="color: red;">ไม่พบข้อมูลกิจกรรม โปรดกลับไปที่หน้ากิจกรรมก่อนครับ</p>
        <?php endif; ?>

        <div style="margin-bottom: 25px;">
            <label for="otp_code" style="display: block; font-weight: bold; margin-bottom: 10px; color: #444; font-size: 1.1em;">รหัสเข้างาน (6 หลัก)</label>

            <input type="text" id="otp_code" name="otp_code" maxlength="6" pattern="\d{6}" required
                style="width: 100%; box-sizing: border-box; padding: 15px; font-size: 32px; text-align: center; letter-spacing: 8px; border: 2px solid #007bff; border-radius: 8px; outline: none;"
                placeholder="------" autocomplete="off" autofocus>
        </div>

        <button type="submit" style="width: 100%; padding: 15px; background-color: #28a745; color: white; border: none; border-radius: 8px; font-size: 1.2em; font-weight: bold; cursor: pointer;">
            🔍 ตรวจสอบและยืนยันการเข้างาน
        </button>

    </form>

    <div style="margin-top: 20px;">
        <?php if (isset($data['event_id'])): ?>
            <a href="/event-detail?id=<?= htmlspecialchars($data['event_id']) ?>" style="color: #6c757d; text-decoration: none;">&larr; กลับไปหน้ารายละเอียดกิจกรรม</a>
        <?php else: ?>
            <a href="/events" style="color: #6c757d; text-decoration: none;">&larr; กลับไปหน้ากิจกรรมทั้งหมด</a>
        <?php endif; ?>
    </div>

</main>

<?php include 'footer.php'; ?>