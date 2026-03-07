<!-- tempplates/otp-user.php -->
<?php include 'header.php'; ?>

<main style="padding: 40px 20px; text-align: center; font-family: sans-serif;">
    <h2 style="color: #333;"><?= htmlspecialchars($data['title']) ?></h2>
    <p style="color: #666; margin-bottom: 20px;">กรุณานำรหัสตัวเลขด้านล่างไปกรอกเพื่อยืนยันตัวตนของคุณ</p>

    <div style="margin: 0 auto; padding: 20px 40px; background-color: #f8f9fa; border: 2px dashed #007bff; border-radius: 10px; display: inline-block;">
        <span style="font-size: 48px; font-weight: bold; letter-spacing: 10px; color: #007bff;">
            <?= $data['otp'] ?>
        </span>
    </div>

    <p style="color: #dc3545; font-size: 0.9em; margin-top: 15px;">
        <small>⚠️ รหัสนี้มีอายุการใช้งาน 30 นาที ห้ามเปิดเผยแก่บุคคลอื่น</small>
    </p>

</main>


<?php include 'footer.php'; ?>