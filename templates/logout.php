<!DOCTYPE html>
<html lang="th">

<head>
    <title>ออกจากระบบ | Event for you</title>
    <meta http-equiv="refresh" content="3;url=/">
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="min-h-[70vh] flex items-center justify-center px-4 py-12 relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-[#00ADB5]/5 rounded-full blur-[120px]"></div>

        <div class="max-w-md w-full bg-[#393E46] rounded-[3rem] p-10 md:p-12 shadow-2xl border border-[#EEEEEE]/5 text-center relative z-10">
            <div class="w-24 h-24 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-8 border border-red-500/20">
                <i class="fas fa-sign-out-alt text-red-400 text-4xl"></i>
            </div>

            <h2 class="text-3xl font-bold text-[#EEEEEE] mb-4 tracking-tight">ออกจากระบบสำเร็จ</h2>
            <div class="space-y-6 mb-10">
                <p class="text-[#EEEEEE]/50 leading-relaxed font-light px-4">
                    ขอบคุณที่มาเป็นส่วนหนึ่งของ <span class="text-[#00ADB5] font-bold">Event for you</span> <br>
                    เราหวังว่าจะได้พบคุณอีกครั้งในเร็วๆ นี้
                </p>

                <div class="bg-[#222831]/50 p-4 rounded-2xl border border-[#EEEEEE]/5 flex flex-col items-center gap-3">
                    <p class="text-[10px] text-[#EEEEEE]/30 uppercase font-bold tracking-[0.2em]">กำลังพากลับหน้าแรกใน 3 วินาที</p>
                    <div class="w-32 bg-[#393E46] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-[#00ADB5] h-full animate-loading-bar"></div>
                    </div>
                </div>
            </div>

            <a href="/" class="inline-flex items-center gap-2 text-[#00ADB5] font-bold hover:underline group">
                คลิกที่นี่หากไม่เปลี่ยนหน้าอัตโนมัติ
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </main>

    <style>
        /* Animation สำหรับแถบโหลด */
        @keyframes loadingBar {
            from {
                width: 0%;
            }

            to {
                width: 100%;
            }
        }

        .animate-loading-bar {
            animation: loadingBar 3s linear forwards;
        }
    </style>

    <?php include 'footer.php' ?>
</body>

</html>