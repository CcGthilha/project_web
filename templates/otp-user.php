<!DOCTYPE html>
<html lang="th">

<head>
    <title>รหัสยืนยันตัวตน | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php'; ?>

    <main class="min-h-[70vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-[#393E46] rounded-[3rem] p-10 md:p-12 shadow-2xl border border-[#EEEEEE]/5 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#00ADB5]/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-[#222831] rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-inner border border-[#00ADB5]/20">
                    <i class="fas fa-shield-alt text-[#00ADB5] text-3xl"></i>
                </div>

                <h2 class="text-2xl font-bold text-[#EEEEEE] mb-2 tracking-tight">
                    <?= htmlspecialchars($data['title']) ?>
                </h2>
                <p class="text-[#EEEEEE]/40 text-sm mb-10 font-light">
                    กรุณาแสดงรหัสตัวเลขด้านล่างนี้แก่เจ้าหน้าที่ <br>เพื่อยืนยันการเข้างานของคุณ
                </p>

                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#00ADB5] to-blue-500 rounded-[2rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-[#222831] py-8 px-6 rounded-[2rem] border border-[#00ADB5]/30 flex flex-col items-center justify-center shadow-inner">
                        <span class="text-5xl md:text-6xl font-black tracking-[15px] text-[#00ADB5] mr-[-15px] drop-shadow-[0_0_15px_rgba(0,173,181,0.3)]">
                            <?= $data['otp'] ?>
                        </span>
                    </div>
                </div>

                <div class="mt-10 p-4 bg-red-500/5 rounded-2xl border border-red-500/10">
                    <p class="text-red-400 text-xs leading-relaxed">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        รหัสนี้จะหมดอายุใน <strong id="countdown"></strong> <br>
                        กรุณาอย่าเปิดเผยรหัสนี้แก่บุคคลอื่นที่ไม่เกี่ยวข้อง
                    </p>
                </div>

                <div class="mt-8">
                    <a href="/list-join-events" class="text-[#EEEEEE]/30 text-xs hover:text-[#00ADB5] transition-all flex items-center justify-center gap-2 uppercase tracking-widest font-bold">
                        <i class="fas fa-chevron-left text-[10px]"></i> กลับสู่รายการกิจกรรม
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    <script>
        let seconds = <?= $data['seconds_remaining'] ?>;

        function updateCountdown() {
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            document.getElementById('countdown').textContent = m + ':' + s;

            if (seconds <= 0) {
                // OTP หมดอายุ reload หน้าเพื่อดึง OTP ใหม่
                location.reload();
            } else {
                seconds--;
                setTimeout(updateCountdown, 1000);
            }
        }

        updateCountdown();
    </script>
</body>

</html>