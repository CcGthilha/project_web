<!DOCTYPE html>
<html lang="th">

<head>
    <title>เปลี่ยนรหัสผ่าน | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-[#393E46] rounded-[2.5rem] p-8 md:p-10 shadow-2xl border border-[#EEEEEE]/5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#00ADB5]/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>

            <div class="relative z-10">
                <div class="text-center mb-10">
                    <div class="w-16 h-16 bg-[#00ADB5]/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-[#00ADB5] text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#EEEEEE]">เปลี่ยนรหัสผ่าน</h2>
                    <p class="text-[#EEEEEE]/40 text-sm mt-2">โปรดระบุรหัสผ่านใหม่ที่คาดเดาได้ยาก</p>
                </div>

                <?php if (isset($data['result'])): $row = $data['result']->fetch_object(); ?>
                    <div class="bg-[#222831]/50 rounded-2xl p-4 mb-8 flex items-center gap-4 border border-[#00ADB5]/10">
                        <div class="w-10 h-10 rounded-full bg-[#393E46] flex items-center justify-center text-[#00ADB5] border border-[#00ADB5]/20">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest">ผู้ใช้งาน</p>
                            <p class="text-[#EEEEEE] font-medium"><?= htmlspecialchars($row->name) ?></p>
                        </div>
                    </div>

                    <form action="chpw?id=<?= $row->user_id ?>" method="post" class="space-y-6">
                        <div class="space-y-2">
                            <label for="password" class="text-xs text-[#EEEEEE]/50 ml-2">รหัสผ่านใหม่</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#EEEEEE]/20"></i>
                                <input type="password" id="password" name="password" required
                                    class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 pl-12 pr-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] focus:ring-1 focus:ring-[#00ADB5] transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="confirm_password" class="text-xs text-[#EEEEEE]/50 ml-2">ยืนยันรหัสผ่านใหม่</label>
                            <div class="relative">
                                <i class="fas fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-[#EEEEEE]/20"></i>
                                <input type="password" id="confirm_password" name="confirm_password" required
                                    class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 pl-12 pr-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] focus:ring-1 focus:ring-[#00ADB5] transition-all"
                                    placeholder="••••••••">
                            </div>
                            <p id="password-error" class="text-[11px] mt-1 ml-2 min-h-[1rem] transition-all"></p>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-lg hover:shadow-[0_10px_25px_rgba(0,173,181,0.3)] hover:scale-[1.02] active:scale-95 transition-all mt-4"
                            onclick="return confirm('ยืนยันการเปลี่ยนรหัสผ่าน?')">
                            บันทึกรหัสผ่านใหม่
                        </button>
                    </form>
                <?php endif; ?>

                <div class="mt-8 text-center">
                    <a href="/personal" class="text-[#EEEEEE]/30 text-xs hover:text-[#00ADB5] transition">ยกเลิกและกลับหน้าโปรไฟล์</a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>

    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const errorText = document.getElementById('password-error');

        function checkPassword() {
            if (confirmPassword.value === "") {
                errorText.textContent = "";
                confirmPassword.style.borderColor = "#393E46";
                return;
            }

            if (password.value !== confirmPassword.value) {
                errorText.textContent = "✘ รหัสผ่านไม่ตรงกัน";
                errorText.style.color = "#ff6b6b"; // Red
                confirmPassword.style.borderColor = "#ff6b6b";
            } else {
                errorText.textContent = "✓ รหัสผ่านตรงกัน";
                errorText.style.color = "#00ADB5"; // Teal
                confirmPassword.style.borderColor = "#00ADB5";
            }
        }

        password.addEventListener("input", checkPassword);
        confirmPassword.addEventListener("input", checkPassword);
    </script>
</body>

</html>