<!DOCTYPE html>
<html lang="th">

<head>
    <title>ส่งคำขอสำเร็จ | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="min-h-[70vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-[#393E46] rounded-[3rem] p-10 md:p-12 shadow-2xl border border-[#EEEEEE]/5 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-32 h-32 bg-[#00ADB5]/10 rounded-full -ml-16 -mt-16 blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-24 h-24 bg-[#00ADB5]/10 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner border border-[#00ADB5]/20">
                    <i class="fas fa-check-circle text-[#00ADB5] text-5xl animate-bounce"></i>
                </div>

                <h2 class="text-3xl font-bold text-[#EEEEEE] mb-4 tracking-tight">ส่งคำขอสำเร็จ!</h2>
                <div class="space-y-4 mb-10">
                    <p class="text-[#EEEEEE]/60 leading-relaxed font-light">
                        ระบบได้รับคำขอเข้าร่วมกิจกรรม <br>
                        <span class="text-[#00ADB5] font-semibold">"<?= htmlspecialchars($data['title']) ?>"</span> <br>
                        ของคุณเรียบร้อยแล้ว
                    </p>
                    <div class="bg-[#222831]/50 p-4 rounded-2xl border border-[#EEEEEE]/5">
                        <p class="text-xs text-[#EEEEEE]/40 uppercase font-bold tracking-widest mb-1">สถานะปัจจุบัน</p>
                        <p class="text-orange-400 text-sm font-bold flex items-center justify-center gap-2">
                            <i class="fas fa-hourglass-half text-[10px]"></i> รอเจ้าของกิจกรรมอนุมัติ
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="/list-join-events"
                        class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-lg hover:shadow-[0_10px_25px_rgba(0,173,181,0.3)] hover:scale-[1.02] transition-all">
                        ดูรายการที่เข้าร่วม
                    </a>
                    <a href="/main"
                        class="w-full py-4 bg-transparent text-[#EEEEEE]/40 rounded-2xl font-bold text-sm hover:text-[#00ADB5] transition-all">
                        กลับสู่หน้าสำรวจกิจกรรม
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>