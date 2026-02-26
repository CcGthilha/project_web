<html>

<head></head>

<body>
    <?php include 'header.php' ?>

    <!-- ส่วนแสดงผลหลักของหน้า -->
    <main>
        <h1>เข้าสู่ระบบ</h1>
        <?php if (!empty($data['error'])): ?>
            <p style="color: red;"><?= htmlspecialchars($data['error']) ?></p>
        <?php endif; ?>
        <form action="login" method="post">
            <label for="username">อีเมลผู้ใช้</label><br>
            <input type="text" name="email" id="email" /><br>
            <label for="password">รหัสผ่าน</label><br>
            <input type="password" name="password" id="password" /><br>
            <button type="submit" style="margin-top: 10px; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">เข้าสู่ระบบ</button>
            
        </form>
        <p style="margin-top: 15px;">ยังไม่มีบัญชี? <a href="/register">สมัครสมาชิก</a></p>
    </main>
    <!-- ส่วนแสดงผลหลักของหน้า -->

    <?php include 'footer.php' ?>
</body>

</html>