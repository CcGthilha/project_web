<html>

<head></head>

<body>
    <?php include 'header.php' ?>

    <!-- ส่วนแสดงผลหลักของหน้า -->
    <main>
        <h1>เปลี่ยนรหัสผ่าน</h1>
        <?php
        if (isset($data['result'])) {
            $row = $data['result']->fetch_object();
        ?>
            <label for="name"><?= $row->name ?></label> </label><br>
            <form action="chpw?id=<?= $row->user_id ?>" method="post">
               <label for="password">รหัสผ่านใหม่</label><br>
                <input type="password" id="password" name="password" required><br>
                <label for="confirm_password">ยืนยันรหัสผ่าน</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br>
                <span id="password-error" style="color: red;"></span><br>
                <button type="submit" onclick="return confirm('ยืนยันการเปลี่ยนรหัสผ่าน?')">Submit</button>
            </form>
        <?php
        }
        ?>
    </main>
    <!-- ส่วนแสดงผลหลักของหน้า -->

    <?php include 'footer.php' ?>
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const errorText = document.getElementById('password-error');

        function checkPassword() {
            if (confirmPassword.value === "") {
                errorText.textContent = "";
                return;
            }

            if (password.value !== confirmPassword.value) {
                errorText.textContent = "รหัสผ่านไม่ตรงกัน";
                errorText.style.color = "red";
            } else {
                errorText.textContent = "รหัสผ่านตรงกัน ✓";
                errorText.style.color = "green";
            }
        }

        password.addEventListener("input", checkPassword);
        confirmPassword.addEventListener("input", checkPassword);
    </script>
</body>

</html>