<!DOCTYPE html>
<html lang="th">

<head>
    <title>สมัครสมาชิกสำเร็จ | Event for you</title>
    <meta http-equiv="refresh" content="5;url=/login">
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-[#393E46] rounded-[3rem] p-10 md:p-12 shadow-2xl border border-[#EEEEEE]/5 text-center relative overflow-hidden">

            <div class="absolute top-0 right-0 w-32 h-32 bg-[#00ADB5]/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-24 h-24 bg-[#00ADB5]/10 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner border border-[#00ADB5]/20">
                    <i class="fas fa-user-check text-[#00ADB5] text-4xl animate-bounce"></i>
                </div>

                <h2 class="text-3xl font-bold text-[#EEEEEE] mb-4 tracking-tight">ยินดีด้วย!</h2>
                <div class="space-y-4 mb-10">
                    <p class="text-[#EEEEEE]/60 leading-relaxed font-light text-lg">
                        คุณได้สมัครสมาชิก <span class="text-[#00ADB5] font-bold">Event for you</span> สำเร็จแล้ว!
                    </p>
                    <p class="text-sm text-[#EEEEEE]/30">
                        เตรียมตัวพบกับกิจกรรมที่น่าสนใจมากมายที่รอคุณอยู่
                    </p>
                </div>

                <div class="space-y-6">
                    <button onclick="window.location.href='/login'"
                        class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-lg hover:shadow-[0_10px_25px_rgba(0,173,181,0.3)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                        <span>เข้าสู่ระบบทันที</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </button>

                    <div class="flex flex-col items-center gap-3">
                        <p class="text-[10px] text-[#EEEEEE]/20 uppercase font-bold tracking-[0.2em]">
                            ระบบจะพาคุณไปหน้าเข้าสู่ระบบอัตโนมัติ
                        </p>
                        <div class="w-24 bg-[#222831] h-1 rounded-full overflow-hidden">
                            <div class="bg-[#00ADB5] h-full animate-loading-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Progress Bar Animation 5 วินาที */
        @keyframes loadingBar {
            from {
                width: 0%;
            }

            to {
                width: 100%;
            }
        }

        .animate-loading-bar {
            animation: loadingBar 5s linear forwards;
        }
    </style>

    <?php include 'footer.php' ?>
</body>

</html>