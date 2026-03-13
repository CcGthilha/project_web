<!DOCTYPE html>
<html lang="th">

<head>
    <title>จัดการผู้สมัคร | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20">
                    <i class="fas fa-users-cog text-[#222831] text-xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#EEEEEE] tracking-tight"><?= htmlspecialchars($data['title']) ?></h2>
                    <p class="text-[#EEEEEE]/60 text-base font-light font-sans">ตรวจสอบรายละเอียดและจัดการผู้เข้าร่วมกิจกรรม</p>
                </div>
            </div>
            <a href="/events" class="text-[#EEEEEE]/60 hover:text-[#00ADB5] transition-all text-sm flex items-center group font-medium font-sans">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> กลับไปหน้ากิจกรรมของคุณ
            </a>
        </div>

        <div class="bg-[#393E46] rounded-[2.5rem] border border-[#EEEEEE]/10 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto font-sans">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#222831]/70 border-b border-[#EEEEEE]/10">
                            <th class="px-8 py-6 text-sm text-[#00ADB5] uppercase font-bold tracking-widest">ผู้สมัคร</th>
                            <th class="px-8 py-6 text-sm text-[#00ADB5] uppercase font-bold tracking-widest">ข้อมูลส่วนตัว</th>
                            <th class="px-8 py-6 text-sm text-[#00ADB5] uppercase font-bold tracking-widest">วันที่สมัคร</th>
                            <th class="px-8 py-6 text-sm text-[#00ADB5] uppercase font-bold tracking-widest text-center">สถานะ</th>
                            <th class="px-8 py-6 text-sm text-[#00ADB5] uppercase font-bold tracking-widest text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EEEEEE]/5">
                        <?php if ($data['participants']->num_rows > 0): ?>
                            <?php while ($p = $data['participants']->fetch_assoc()): ?>
                                <tr class="hover:bg-[#222831]/40 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl bg-[#222831] border border-[#00ADB5]/30 flex items-center justify-center text-[#00ADB5] text-lg font-bold shadow-inner">
                                                <?= mb_substr($p['name'], 0, 1) ?>
                                            </div>
                                            <span class="text-[#EEEEEE] text-lg font-semibold"><?= htmlspecialchars($p['name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <button type="button" 
                                            class="btn-view-profile px-4 py-2 bg-[#00ADB5]/10 text-[#00ADB5] rounded-xl text-xs font-bold hover:bg-[#00ADB5] hover:text-[#222831] transition-all flex items-center gap-2"
                                            data-name="<?= htmlspecialchars($p['name']) ?>"
                                            data-email="<?= htmlspecialchars($p['email']) ?>"
                                            data-birth="<?= htmlspecialchars(date('d M Y', strtotime($p['birth_date'] ?? ''))) ?>"
                                            data-job="<?= htmlspecialchars($p['occupation'] ?? 'ไม่ระบุอาชีพ') ?>"
                                            data-province="<?= htmlspecialchars($p['province'] ?? 'ไม่ระบุจังหวัด') ?>">
                                            <i class="fas fa-id-card"></i> ดูรายละเอียด
                                        </button>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-[#EEEEEE]/80 text-sm font-light">
                                            <i class="far fa-clock mr-1 text-[#00ADB5]"></i>
                                            <?= date('d M Y, H:i', strtotime($p['registered_at'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <?php if ($p['status'] === 'pending'): ?>
                                            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-orange-500/10 text-orange-400 text-[10px] font-bold uppercase border border-orange-500/20">
                                                <span class="w-1.5 h-1.5 bg-orange-400 rounded-full animate-pulse"></span> รอการอนุมัติ
                                            </span>
                                        <?php elseif ($p['status'] === 'attended'): ?>
                                            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-green-500/10 text-green-400 text-[10px] font-bold uppercase border border-green-500/20">
                                                ✅ เข้าร่วมงานแล้ว
                                            </span>
                                        <?php elseif ($p['status'] === 'approved'): ?>
                                            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-[#00ADB5]/10 text-[#00ADB5] text-[10px] font-bold uppercase border border-[#00ADB5]/20">
                                                อนุมัติแล้ว
                                            </span>
                                        <?php elseif ($p['status'] === 'rejected'): ?>
                                            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-red-500/10 text-red-400 text-[10px] font-bold uppercase border border-red-500/20">
                                                ปฏิเสธแล้ว
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-center gap-3">
                                            <?php if ($p['status'] === 'pending'): ?>
                                                <form action="/approve-participant" method="POST" class="form-confirm">
                                                    <input type="hidden" name="reg_id" value="<?= $p['registrations_id'] ?>">
                                                    <input type="hidden" name="event_id" value="<?= $p['event_id'] ?>">
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="button" class="btn-approve w-11 h-11 bg-green-500 text-[#222831] rounded-xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all shadow-lg shadow-green-500/20">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="/approve-participant" method="POST" class="form-confirm">
                                                    <input type="hidden" name="reg_id" value="<?= $p['registrations_id'] ?>">
                                                    <input type="hidden" name="event_id" value="<?= $p['event_id'] ?>">
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="button" class="btn-reject w-11 h-11 bg-[#222831] text-red-500 rounded-xl flex items-center justify-center border-2 border-red-500/30 hover:bg-red-500 hover:text-white transition-all shadow-lg">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-[#EEEEEE]/10 text-[10px] font-bold tracking-widest uppercase italic">COMPLETED</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center gap-6 opacity-30">
                                        <i class="fas fa-users-slash text-6xl text-[#00ADB5]"></i>
                                        <p class="text-xl font-medium">ยังไม่มีผู้สมัครในขณะนี้</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>

    <script>
        // 1. ป๊อปอัพแสดงข้อมูลส่วนตัวผู้สมัคร
        document.querySelectorAll('.btn-view-profile').forEach(btn => {
            btn.addEventListener('click', function() {
                const data = {
                    name: this.getAttribute('data-name'),
                    email: this.getAttribute('data-email'),
                    birth: this.getAttribute('data-birth'),
                    job: this.getAttribute('data-job'),
                    province: this.getAttribute('data-province')
                };

                MySwal.fire({
                    title: `<span class="text-[#00ADB5] font-bold">${data.name}</span>`,
                    html: `
                        <div class="text-left space-y-3 mt-6 font-sans">
                            <div class="bg-[#222831]/50 p-4 rounded-2xl border border-[#EEEEEE]/5">
                                <p class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest mb-1">อีเมล</p>
                                <p class="text-[#EEEEEE] font-medium">${data.email}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-[#222831]/50 p-4 rounded-2xl border border-[#EEEEEE]/5">
                                    <p class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest mb-1">วันเกิด</p>
                                    <p class="text-[#EEEEEE] font-medium">${data.birth}</p>
                                </div>
                                <div class="bg-[#222831]/50 p-4 rounded-2xl border border-[#EEEEEE]/5">
                                    <p class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest mb-1">จังหวัด</p>
                                    <p class="text-[#EEEEEE] font-medium">${data.province}</p>
                                </div>
                            </div>
                            <div class="bg-[#222831]/50 p-4 rounded-2xl border border-[#EEEEEE]/5">
                                <p class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest mb-1">อาชีพ</p>
                                <p class="text-[#EEEEEE] font-medium">${data.job}</p>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    iconColor: '#00ADB5',
                    confirmButtonText: 'ปิดหน้าต่าง',
                    confirmButtonColor: '#393E46',
                });
            });
        });

        // 2. ยืนยันการอนุมัติ/ปฏิเสธ
        const setupConfirm = (selector, title, color, confirmText) => {
            document.querySelectorAll(selector).forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    MySwal.fire({
                        title: `<span class="text-[#EEEEEE]">${title}</span>`,
                        text: "คุณตรวจสอบข้อมูลผู้สมัครครบถ้วนแล้วใช่หรือไม่?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: color,
                        confirmButtonText: confirmText,
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        };

        setupConfirm('.btn-approve', 'ยืนยันการอนุมัติ?', '#22c55e', 'ใช่, อนุมัติเลย');
        setupConfirm('.btn-reject', 'ปฏิเสธผู้สมัคร?', '#ef4444', 'ใช่, ปฏิเสธ');
    </script>
</body>

</html>