<html>

<head></head>

<body>
    <?php include 'header.php' ?>
    <main>
        <h1><?= $data['title'] ?></h1>
        <section>
            <form action="signup" method="post">
                <label for="name">ชื่อ-สกุล</label><br>
                <input type="text" name="name" id="name" required/><br>
                <label for="gender">เพศ</label><br>
                <select name="gender" id="gender" required>
                    <option value="male">ชาย</option>
                    <option value="female">หญิง</option>
                    <option value="other">อื่นๆ</option>
                </select><br>
                <label for="birth_date" required>วันเกิด</label><br>
                <input type="date" name="birth_date" id="birth_date" required /><br>
                <label for="occupation">อาชีพ</label><br>
                <input type="text" name="occupation" id="occupation"required/><br>
                <label for="province">จังหวัดที่อยู่อาศัย</label><br>
                <input type="text" name="province" id="province" required/><br>
                <label for="email">อีเมล</label><br>
                <input type="email" name="email" id="email" required/><br>
                <label for="password">รหัสผ่าน</label><br>
                <input type="password" id="password" name="password" required><br>
                <label for="confirm_password">ยืนยันรหัสผ่าน</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br>
                <span id="password-error" style="color: red;"></span><br>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
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