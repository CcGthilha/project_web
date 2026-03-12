<!DOCTYPE html>
<html lang="th">

<head>
    <title>สมัครสมาชิก | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-[#393E46] rounded-[3rem] shadow-2xl border border-[#EEEEEE]/5 overflow-hidden flex flex-col md:flex-row">

            <div class="md:w-1/3 bg-[#00ADB5] p-10 flex flex-col justify-center text-[#222831]">
                <div class="w-16 h-16 bg-[#222831] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-user-plus text-[#00ADB5] text-2xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold mb-4 leading-tight">เข้าร่วมกับเรา</h2>
                <p class="text-[#222831]/70 font-medium">เริ่มต้นสร้างและค้นหาประสบการณ์ใหม่ๆ ไปกับ Event for you</p>
                <div class="mt-12 space-y-4 text-sm font-bold">
                    <p><i class="fas fa-check-circle mr-2"></i> จัดการกิจกรรมง่ายๆ</p>
                    <p><i class="fas fa-check-circle mr-2"></i> บันทึกข้อมูลปลอดภัย</p>
                </div>
            </div>

            <div class="md:w-2/3 p-8 md:p-12">
                <h2 class="text-2xl font-bold text-[#EEEEEE] mb-8"><?= htmlspecialchars($data['title']) ?></h2>

                <?php if (isset($data['error'])): ?>
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-2xl text-sm mb-8 flex items-center gap-3 animate-pulse">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?= htmlspecialchars($data['error']) ?></span>
                    </div>
                <?php endif; ?>

                <form action="signup" method="post" id="signupForm" class="space-y-8">

                    <div class="space-y-5">
                        <h3 class="text-[#00ADB5] text-xs uppercase font-bold tracking-[0.2em]">ข้อมูลบัญชี</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="email" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">อีเมลผู้ใช้งาน</label>
                                <input type="email" name="email" id="email" required placeholder="example@gmail.com"
                                    class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label for="password" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">รหัสผ่าน</label>
                                    <input type="password" id="password" name="password" required placeholder="••••••••"
                                        class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label for="confirm_password" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">ยืนยันรหัสผ่าน</label>
                                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••"
                                        class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all">
                                </div>
                            </div>
                            <p id="password-error" class="text-[10px] mt-1 ml-2 min-h-[1.2rem]"></p>
                        </div>
                    </div>

                    <hr class="border-[#EEEEEE]/5">

                    <div class="space-y-5">
                        <h3 class="text-[#00ADB5] text-xs uppercase font-bold tracking-[0.2em]">ข้อมูลส่วนตัว</h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="name" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">ชื่อ-นามสกุล</label>
                                <input type="text" name="name" id="name" required placeholder="ระบุชื่อและนามสกุลของคุณ"
                                    class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label for="gender" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">เพศ</label>
                                    <select name="gender" id="gender" required
                                        class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all cursor-pointer appearance-none">
                                        <option value="male">ชาย</option>
                                        <option value="female">หญิง</option>
                                        <option value="other">อื่นๆ</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label for="birth_date" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">วันเกิด</label>
                                    <input type="date" name="birth_date" id="birth_date" required
                                        class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all [color-scheme:dark]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label for="occupation" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">อาชีพ</label>
                                    <input type="text" name="occupation" id="occupation" required placeholder="เช่น นักศึกษา, พนักงานบริษัท"
                                        class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label for="province" class="text-[11px] text-[#EEEEEE]/40 ml-2 uppercase font-bold">จังหวัดที่อยู่อาศัย</label>
                                    <input type="text" name="province" id="province" required placeholder="เช่น กรุงเทพฯ, ขอนแก่น"
                                        class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-3.5 px-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 text-center">
                        <button type="submit" id="submitBtn"
                            class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-lg hover:shadow-[0_10px_30px_rgba(0,173,181,0.3)] hover:scale-[1.02] active:scale-95 transition-all">
                            สร้างบัญชีผู้ใช้งาน
                        </button>
                        <p class="mt-6 text-sm text-[#EEEEEE]/30">
                            เป็นสมาชิกอยู่แล้ว? <a href="/login" class="text-[#00ADB5] font-bold hover:underline">เข้าสู่ระบบที่นี่</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>

    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const errorText = document.getElementById('password-error');
        const submitBtn = document.getElementById('submitBtn');

        function checkPassword() {
            if (confirmPassword.value === "" || password.value === "") {
                errorText.textContent = "";
                confirmPassword.style.borderColor = "#393E46";
                return;
            }

            if (password.value !== confirmPassword.value) {
                errorText.textContent = "รหัสผ่านไม่ตรงกัน ✘";
                errorText.style.color = "#ff6b6b";
                confirmPassword.style.borderColor = "#ff6b6b";
            } else {
                errorText.textContent = "รหัสผ่านตรงกัน ✓";
                errorText.style.color = "#00ADB5";
                confirmPassword.style.borderColor = "#00ADB5";
            }
        }

        password.addEventListener("input", checkPassword);
        confirmPassword.addEventListener("input", checkPassword);

        document.getElementById('signupForm').onsubmit = function(e) {
            if (password.value !== confirmPassword.value) {
                alert("รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง");
                e.preventDefault();
                return false;
            }
        };
    </script>
</body>

</html>