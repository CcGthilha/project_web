<!DOCTYPE html>
<html lang="th">

<head>
    <title>Event for you | จัดการกิจกรรมเพื่อคุณ</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="relative min-h-[calc(100vh-80px)] flex items-center justify-center px-4 overflow-hidden">
        <div class="absolute top-1/4 -left-20 w-72 h-72 bg-[#00ADB5]/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[120px]"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#393E46] border border-[#EEEEEE]/10 mb-8 animate-pulse">
                <span class="text-xs font-medium text-[#00ADB5]">✨ ยินดีต้อนรับสู่ Event for you</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold text-[#EEEEEE] leading-tight tracking-tighter mb-6">
                ประสบการณ์ใหม่ <br>
                <span class="text-gradient">ที่สร้างมาเพื่อคุณ</span>
            </h1>

            <p class="text-lg md:text-xl text-[#EEEEEE]/60 mb-12 max-w-2xl mx-auto leading-relaxed">
                <?= isset($data['title']) ? $data['title'] : 'Event for you คือพื้นที่สำหรับค้นหาและจัดการกิจกรรมที่ตอบโจทย์ไลฟ์สไตล์ของคุณมากที่สุด' ?>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/main" class="w-full sm:w-auto px-10 py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-lg hover:scale-105 transition-transform shadow-[0_10px_30px_rgba(0,173,181,0.3)] flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i> เริ่มสำรวจเลย
                </a>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="/signup" class="w-full sm:w-auto px-10 py-4 bg-transparent border-2 border-[#393E46] text-[#EEEEEE] rounded-2xl font-bold text-lg hover:bg-[#393E46] transition flex items-center justify-center gap-2">
                        สมัครสมาชิกฟรี <i class="fas fa-arrow-right"></i>
                    </a>
                <?php else: ?>
                    <a href="/events" class="w-full sm:w-auto px-10 py-4 bg-transparent border-2 border-[#393E46] text-[#EEEEEE] rounded-2xl font-bold text-lg hover:bg-[#393E46] transition flex items-center justify-center gap-2">
                        จัดการกิจกรรม <i class="fas fa-plus"></i>
                    </a>
                <?php endif; ?>
            </div>

            <div class="mt-20 grid grid-cols-3 gap-4 border-t border-[#393E46] pt-10">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#EEEEEE]">Easy</div>
                    <div class="text-xs text-[#EEEEEE]/40 uppercase tracking-widest">ใช้งานง่าย</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#00ADB5]">Fast</div>
                    <div class="text-xs text-[#EEEEEE]/40 uppercase tracking-widest">รวดเร็ว</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#EEEEEE]">For You</div>
                    <div class="text-xs text-[#EEEEEE]/40 uppercase tracking-widest">เพื่อคุณ</div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>