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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        // สร้างฟังก์ชันกลางสำหรับตั้งค่าเริ่มต้นของ SweetAlert2 ในเว็บเรา
        const MySwal = Swal.mixin({
            background: '#222831',
            color: '#EEEEEE',
            confirmButtonColor: '#00ADB5',
            cancelButtonColor: '#393E46',
            borderRadius: '1.5rem',
            customClass: {
                popup: 'rounded-[2.5rem] border border-[#EEEEEE]/10 shadow-2xl'
            },
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        });

        // 2. เช็ค Session ทันทีที่โหลดหน้าเสร็จ (ถ้ามีข้อความค้างอยู่ให้เด้งทันที)
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['msg_success'])): ?>
                MySwal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: '<?= $_SESSION['msg_success'] ?>',
                });
                <?php unset($_SESSION['msg_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['msg_error'])): ?>
                MySwal.fire({
                    icon: 'error',
                    title: 'แจ้งเตือน',
                    text: '<?= $_SESSION['msg_error'] ?>',
                });
                <?php unset($_SESSION['msg_error']); ?>
            <?php endif; ?>
        });
    </script>
</head>

<?php
// 🌟 โค้ดใหม่: คำนวณหาจำนวนคนที่ "รอการอนุมัติ" ในกิจกรรมของเรา 🌟
$notify_count = 0;
if (isset($_SESSION['user_id'])) {
    global $conn;
    $user_id_now = $_SESSION['user_id'];

    // ดึงจำนวนคนที่ status = 'pending' ในกิจกรรมที่ user คนนี้เป็นคนสร้าง
    $sql_notify = "SELECT COUNT(r.registrations_id) as total_pending 
                   FROM registrations r 
                   JOIN events e ON r.event_id = e.event_id 
                   WHERE e.user_id = ? AND r.status = 'pending'";

    $stmt_notify = $conn->prepare($sql_notify);
    $stmt_notify->bind_param("i", $user_id_now);
    $stmt_notify->execute();
    $res_notify = $stmt_notify->get_result()->fetch_assoc();

    if ($res_notify) {
        $notify_count = $res_notify['total_pending'];
    }
}
?>

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

            <div class="hidden md:flex items-center gap-1 text-sm font-medium">
                <a href="/" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-[#EEEEEE]/70 hover:text-[#00ADB5] hover:bg-[#00ADB5]/10 transition-all group">
                    <i class="fas fa-home opacity-50 group-hover:opacity-100 transition-opacity"></i> หน้าแรก
                </a>
                <a href="/main" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-[#EEEEEE]/70 hover:text-[#00ADB5] hover:bg-[#00ADB5]/10 transition-all group">
                    <i class="fas fa-compass opacity-50 group-hover:opacity-100 transition-opacity"></i> กิจกรรมทั้งหมด
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="h-6 w-px bg-[#EEEEEE]/10 mx-2"></div>

                    <a href="/list-join-events" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-[#EEEEEE]/70 hover:text-[#00ADB5] hover:bg-[#00ADB5]/10 transition-all group">
                        <i class="fas fa-ticket-alt opacity-50 group-hover:opacity-100 transition-opacity"></i> ที่เข้าร่วม
                    </a>

                    <a href="/events" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-[#EEEEEE]/70 hover:text-[#00ADB5] hover:bg-[#00ADB5]/10 transition-all group">
                        <i class="fas fa-tasks opacity-50 group-hover:opacity-100 transition-opacity"></i> กิจกรรมของคุณ
                        <?php if ($notify_count > 0): ?>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.5)]">
                                <?= $notify_count > 99 ? '99+' : $notify_count ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="h-6 w-px bg-[#EEEEEE]/10 mx-2"></div>

                    <a href="/personal" class="flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-[#393E46]/50 transition-all group cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-[#393E46] border border-[#00ADB5]/30 flex items-center justify-center group-hover:border-[#00ADB5] transition-colors">
                            <i class="fas fa-user text-xs text-[#00ADB5]"></i>
                        </div>
                        <span class="text-[#EEEEEE]/90 group-hover:text-white transition-colors">โปรไฟล์</span>
                    </a>
                    <a href="/logout"
                        id="btn-logout-desktop"
                        class="w-10 h-10 flex items-center justify-center rounded-xl text-red-400/70 hover:text-red-400 hover:bg-red-500/10 transition-all"
                        title="ออกจากระบบ">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <div class="h-6 w-px bg-[#EEEEEE]/10 mx-2"></div>
                    <a href="/login" class="px-4 py-2.5 rounded-xl text-[#EEEEEE]/70 hover:text-[#00ADB5] transition-all">เข้าสู่ระบบ</a>
                    <a href="/signup"
                        class="ml-2 px-6 py-2.5 bg-[#00ADB5] text-[#222831] rounded-full font-bold hover:shadow-[0_0_20px_rgba(0,173,181,0.4)] transition-all active:scale-95">
                        สมัครสมาชิก
                    </a>
                <?php endif; ?>
            </div>

            <button id="menuBtn" class="md:hidden text-[#00ADB5] text-2xl focus:outline-none relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-[#00ADB5]/10 transition-colors">
                <i class="fas fa-bars-staggered" id="menuIcon"></i>
                <?php if (isset($_SESSION['user_id']) && $notify_count > 0): ?>
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-[#222831]"></span>
                <?php endif; ?>
            </button>
        </div>

        <div id="mobileMenu" class="hidden flex flex-col gap-2 mt-5 pb-4 md:hidden">
            <a href="/" class="flex items-center gap-3 p-4 rounded-xl bg-[#393E46]/30 hover:bg-[#393E46]/80 text-[#EEEEEE]/90 transition-colors">
                <i class="fas fa-home text-[#00ADB5] w-5 text-center"></i> หน้าแรก
            </a>
            <a href="/main" class="flex items-center gap-3 p-4 rounded-xl bg-[#393E46]/30 hover:bg-[#393E46]/80 text-[#EEEEEE]/90 transition-colors">
                <i class="fas fa-compass text-[#00ADB5] w-5 text-center"></i> กิจกรรมทั้งหมด
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="h-px w-full bg-[#EEEEEE]/5 my-2"></div>

                <a href="/list-join-events" class="flex items-center gap-3 p-4 rounded-xl bg-[#393E46]/30 hover:bg-[#393E46]/80 text-[#EEEEEE]/90 transition-colors">
                    <i class="fas fa-ticket-alt text-[#00ADB5] w-5 text-center"></i> กิจกรรมที่เข้าร่วม
                </a>

                <a href="/events" class="flex items-center justify-between p-4 rounded-xl bg-[#393E46]/30 hover:bg-[#393E46]/80 text-[#EEEEEE]/90 transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-tasks text-[#00ADB5] w-5 text-center"></i> กิจกรรมของคุณ
                    </div>
                    <?php if ($notify_count > 0): ?>
                        <span class="bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg shadow-red-500/30">
                            <?= $notify_count ?> รออนุมัติ
                        </span>
                    <?php endif; ?>
                </a>

                <div class="h-px w-full bg-[#EEEEEE]/5 my-2"></div>

                <a href="/personal" class="flex items-center justify-between p-4 rounded-xl bg-[#393E46]/30 hover:bg-[#393E46]/80 text-[#EEEEEE]/90 transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-circle text-[#00ADB5] w-5 text-center"></i> โปรไฟล์
                    </div>
                    <i class="fas fa-chevron-right text-[#EEEEEE]/30 text-xs"></i>
                </a>
                <a href="/logout"
                    id="btn-logout-mobile"
                    class="flex items-center gap-3 p-4 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 font-bold transition-colors">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i> ออกจากระบบ
                </a>
            <?php else: ?>
                <div class="h-px w-full bg-[#EEEEEE]/5 my-2"></div>
                <a href="/login" class="p-4 rounded-xl bg-[#393E46]/30 text-center text-[#EEEEEE]/90 hover:bg-[#393E46]/80 transition-colors">เข้าสู่ระบบ</a>
                <a href="/signup" class="p-4 rounded-xl bg-[#00ADB5] text-[#222831] font-bold text-center shadow-lg shadow-[#00ADB5]/20 active:scale-95 transition-all">สมัครสมาชิก</a>
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
<script>
    // ฟังก์ชันกลางสำหรับยืนยันการออกจากระบบ
    const handleLogout = (e) => {
        e.preventDefault(); // ป้องกันการเปลี่ยนหน้าทันที
        const logoutUrl = e.currentTarget.getAttribute('href');

        MySwal.fire({
            title: '<span class="text-[#EEEEEE]">ออกจากระบบ?</span>',
            text: "คุณต้องการออกจากระบบใช่หรือไม่?",
            icon: 'warning',
            iconColor: '#ef4444',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // สีแดงเพื่อให้ดูเด่นชัด
            cancelButtonColor: '#393E46',
            confirmButtonText: 'ใช่, ออกจากระบบ',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutUrl;
            }
        });
    };

    // ผูกเหตุการณ์กับปุ่มทั้ง Desktop และ Mobile
    document.getElementById('btn-logout-desktop')?.addEventListener('click', handleLogout);
    document.getElementById('btn-logout-mobile')?.addEventListener('click', handleLogout);
</script>