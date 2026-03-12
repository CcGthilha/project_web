<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #222831;
            color: #EEEEEE;
        }

        .glass-nav {
            background: rgba(34, 40, 49, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(238, 238, 238, 0.1);
        }

        .text-gradient {
            background: linear-gradient(to right, #00ADB5, #00FFF0);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<header class="sticky top-0 z-50 glass-nav">
    <nav class="max-w-7xl mx-auto px-5 py-4">
        <div class="flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2 group">
                <div class="w-10 h-10 bg-[#00ADB5] rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform shadow-lg shadow-[#00ADB5]/20">
                    <i class="fas fa-star text-[#222831] text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-tighter">
                    Event <span class="text-[#00ADB5]">for you</span>
                </h1>
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="/" class="text-[#EEEEEE] hover:text-[#00ADB5] transition">หน้าแรก</a>
                <a href="/main" class="text-[#EEEEEE] hover:text-[#00ADB5] transition">กิจกรรมทั้งหมด</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/list-join-events" class="text-[#EEEEEE] hover:text-[#00ADB5] transition">ที่เข้าร่วม</a>
                    <a href="/events" class="text-[#EEEEEE] hover:text-[#00ADB5] transition">กิจกรรมของคุณ</a>
                    <div class="h-6 w-px bg-[#393E46]"></div>
                    <a href="/personal" class="flex items-center gap-2 hover:text-[#00ADB5] transition">
                        <div class="w-8 h-8 rounded-full bg-[#393E46] border border-[#00ADB5]/30 flex items-center justify-center">
                            <i class="fas fa-user text-xs"></i>
                        </div>
                        <span>โปรไฟล์</span>
                    </a>
                    <a href="/logout"
                        class="text-red-400 hover:text-red-300 font-bold transition"
                        onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่?');">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a href="/login" class="text-[#EEEEEE] hover:text-[#00ADB5] transition">เข้าสู่ระบบ</a>
                    <a href="/signup"
                        class="px-6 py-2.5 bg-[#00ADB5] text-[#222831] rounded-full font-bold hover:shadow-[0_0_20px_rgba(0,173,181,0.4)] transition-all active:scale-95">
                        สมัครสมาชิก
                    </a>
                <?php endif; ?>
            </div>

            <button id="menuBtn" class="md:hidden text-[#00ADB5] text-2xl focus:outline-none">
                <i class="fas fa-bars-staggered" id="menuIcon"></i>
            </button>
        </div>

        <div id="mobileMenu" class="hidden flex flex-col gap-3 mt-5 pb-4 md:hidden">
            <a href="/" class="p-3 rounded-xl bg-[#393E46]/50 text-[#EEEEEE]">หน้าแรก</a>
            <a href="/main" class="p-3 rounded-xl bg-[#393E46]/50 text-[#EEEEEE]">กิจกรรมทั้งหมด</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/list-join-events" class="p-3 rounded-xl bg-[#393E46]/50">กิจกรรมที่เข้าร่วม</a>
                <a href="/events" class="p-3 rounded-xl bg-[#393E46]/50">กิจกรรมของคุณ</a>
                <a href="/personal" class="p-3 rounded-xl bg-[#393E46]/50 flex justify-between">
                    โปรไฟล์ <i class="fas fa-chevron-right text-[#00ADB5]"></i>
                </a>
                <a href="/logout" class="p-3 rounded-xl bg-red-500/10 text-red-400 font-bold"
                    onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่?');">
                    ออกจากระบบ
                </a>
            <?php else: ?>
                <a href="/login" class="p-3 rounded-xl bg-[#393E46]/50">เข้าสู่ระบบ</a>
                <a href="/signup" class="p-4 rounded-xl bg-[#00ADB5] text-[#222831] font-bold text-center">สมัครสมาชิก</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script>
    const btn = document.getElementById("menuBtn");
    const menu = document.getElementById("mobileMenu");
    const icon = document.getElementById("menuIcon");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
        icon.classList.toggle("fa-bars-staggered");
        icon.classList.toggle("fa-xmark");
    });
</script>