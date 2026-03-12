<!DOCTYPE html>
<html lang="th">

<head>
    <title>ตรวจสอบรหัสเข้างาน | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php'; ?>

    <main class="min-h-[80vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-[#393E46] rounded-[3rem] p-8 md:p-12 shadow-2xl border border-[#EEEEEE]/5 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-32 h-32 bg-[#00ADB5]/5 rounded-full -ml-16 -mt-16 blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-[#222831] rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-inner border border-[#00ADB5]/20">
                    <i class="fas fa-user-check text-[#00ADB5] text-3xl"></i>
                </div>

                <?php if (isset($data['title'])): ?>
                    <h2 class="text-2xl font-bold text-[#EEEEEE] tracking-tight mb-2"><?= htmlspecialchars($data['title']) ?></h2>
                <?php else: ?>
                    <h2 class="text-2xl font-bold text-[#EEEEEE] tracking-tight mb-2">ตรวจสอบและยืนยันการเข้างาน</h2>
                <?php endif; ?>

                <p class="text-[#EEEEEE]/40 text-sm mb-10 font-light">
                    สำหรับผู้จัด: กรุณากรอกรหัส OTP 6 หลัก <br>จากมือถือของผู้เข้าร่วมกิจกรรมเพื่อยืนยัน
                </p>

                <form action="/verify-otp" method="POST" class="space-y-8">
                    <?php if (isset($data['event_id'])): ?>
                        <input type="hidden" name="event_id" value="<?= htmlspecialchars($data['event_id']) ?>">
                    <?php else: ?>
                        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-2xl text-xs mb-6">
                            <i class="fas fa-exclamation-circle mr-1"></i> ไม่พบข้อมูลกิจกรรม โปรดกลับไปที่หน้ากิจกรรมก่อนครับ
                        </div>
                    <?php endif; ?>

                    <div class="space-y-4">
                        <label for="otp_code" class="text-xs text-[#00ADB5] uppercase font-bold tracking-[0.2em]">รหัสเข้างาน (6 หลัก)</label>
                        <div class="relative">
                            <input type="text" id="otp_code" name="otp_code" maxlength="6" pattern="\d{6}" required
                                class="w-full bg-[#222831] border-2 border-[#393E46] rounded-[2rem] py-6 px-4 text-4xl md:text-5xl text-center font-black tracking-[10px] text-[#00ADB5] focus:outline-none focus:border-[#00ADB5] focus:ring-4 focus:ring-[#00ADB5]/10 transition-all placeholder:text-[#393E46] selection:bg-[#00ADB5] selection:text-[#222831]"
                                placeholder="000000" autocomplete="off" autofocus>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-5 bg-[#00ADB5] text-[#222831] rounded-[2rem] font-bold text-xl hover:shadow-[0_15px_30px_rgba(0,173,181,0.3)] hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-shield-check"></i> ตรวจสอบข้อมูล
                    </button>
                </form>

                <div class="mt-10">
                    <?php if (isset($data['event_id'])): ?>
                        <a href="/event-detail?event_id=<?= htmlspecialchars($data['event_id']) ?>"
                            class="text-[#EEEEEE]/30 text-xs hover:text-[#00ADB5] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-[10px]"></i> กลับไปหน้ารายละเอียดกิจกรรม
                        </a>
                    <?php else: ?>
                        <a href="/events"
                            class="text-[#EEEEEE]/30 text-xs hover:text-[#00ADB5] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-[10px]"></i> กลับไปหน้ากิจกรรมทั้งหมด
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>