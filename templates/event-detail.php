<!DOCTYPE html>
<html lang="th">
<head>
    <title><?= htmlspecialchars($data['title']) ?> | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <?php
    $event = $data['event'] ?? null;
    $clean_desc = '';
    $max_limit = 0;
    $current_joined = 0;
    $is_full = false;

    if ($event) {
        $now = new DateTime();
        $endDate = new DateTime($event['end_date']);
        $isPast = ($endDate < $now);

        $raw_desc = $event['description'];
        $clean_desc = $raw_desc;

        if (preg_match('/\[MAX:(\d+)\]/i', $raw_desc, $matches)) {
            $max_limit = (int)$matches[1];
            $clean_desc = str_replace($matches[0], '', $raw_desc);
        }

        $current_joined = getParticipantCount($event['event_id']);

        if ($max_limit > 0 && $current_joined >= $max_limit) {
            $is_full = true;
        }
    }
    ?>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <?php if ($event): ?>
            <section class="mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#EEEEEE] mb-8 tracking-tight">
                    <?= htmlspecialchars($data['title']) ?>
                </h1>

                <div class="flex gap-4 overflow-x-auto pb-6 snap-x scrollbar-hide">
                    <?php if (!empty($data['images'])): ?>
                        <?php foreach ($data['images'] as $img): ?>
                            <div class="shrink-0 snap-center">
                                <img src="<?= htmlspecialchars($img) ?>" class="w-[300px] md:w-[450px] h-[200px] md:h-[300px] object-cover rounded-[2rem] border border-[#393E46] shadow-xl">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="w-full h-64 bg-[#393E46] rounded-[2rem] flex flex-col items-center justify-center border-2 border-dashed border-[#EEEEEE]/10 text-[#EEEEEE]/30">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <p>ไม่มีรูปภาพประกอบกิจกรรม</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-[#393E46]/30 p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-sm">
                        <h3 class="text-[#00ADB5] font-bold text-sm uppercase tracking-[0.2em] mb-4">รายละเอียดกิจกรรม</h3>
                        <div class="text-[#EEEEEE]/80 leading-relaxed text-lg font-light">
                            <?= nl2br(htmlspecialchars(trim($clean_desc))) ?>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#00ADB5]/20 shadow-2xl sticky top-28">
                        <div class="space-y-6 mb-10">
                            <span class="text-[#EEEEEE]/50 text-xl font-normal normal-case flex items-center gap-2">
                                เข้าร่วมแล้ว:
                                <span class="<?= $is_full ? 'text-red-400' : 'text-[#00ADB5]' ?> font-bold text-lg">
                                    <?= $current_joined ?> / <?= $max_limit == 0 ? 'ไม่จำกัด' : $max_limit ?>
                                </span>
                            </span>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#00ADB5]/10 rounded-xl flex items-center justify-center text-[#00ADB5] shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-[#EEEEEE]/40 uppercase font-bold tracking-widest">สถานที่</p>
                                    <p class="text-[#EEEEEE] font-medium"><?= htmlspecialchars($event['location']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#00ADB5]/10 rounded-xl flex items-center justify-center text-[#00ADB5] shrink-0">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-[#EEEEEE]/40 uppercase font-bold tracking-widest">เริ่มวันที่</p>
                                    <p class="text-[#EEEEEE] font-medium"><?= date('d M Y - H:i', strtotime($event['start_date'])) ?> น.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#00ADB5]/10 rounded-xl flex items-center justify-center text-[#00ADB5] shrink-0">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-[#EEEEEE]/40 uppercase font-bold tracking-widest">ถึงวันที่</p>
                                    <p class="text-[#EEEEEE] font-medium"><?= date('d M Y - H:i', strtotime($event['end_date'])) ?> น.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['user_id']): ?>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="/edit-event?id=<?= $event['event_id'] ?>" class="flex items-center justify-center py-3 bg-[#222831] text-[#EEEEEE] rounded-xl font-bold border border-[#EEEEEE]/10 hover:border-[#00ADB5] transition-all text-sm">
                                        <i class="fas fa-edit mr-2"></i> แก้ไข
                                    </a>
                                    <a href="#" data-url="/delete-event?id=<?= $event['event_id'] ?>" class="btn-confirm-delete flex items-center justify-center py-3 bg-red-500/10 text-red-400 rounded-xl font-bold border border-red-400/20 hover:bg-red-500 hover:text-white transition-all text-sm">
                                        <i class="fas fa-trash mr-2"></i> ลบ
                                    </a>
                                </div>
                                <?php if (!$isPast): ?>
                                    <form action="/verify-otp" method="post" class="mt-2">
                                        <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['event_id']) ?>">
                                        <button type="submit" class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold shadow-lg hover:shadow-[#00ADB5]/20 transition-all">
                                            <i class="fas fa-qrcode mr-2"></i> ตรวจรหัสเข้างาน (OTP)
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="w-full py-4 bg-[#222831]/50 text-[#EEEEEE]/20 text-center rounded-2xl font-bold text-sm border border-[#EEEEEE]/5 cursor-default mt-2">กิจกรรมสิ้นสุดแล้ว</div>
                                <?php endif; ?>

                            <?php elseif (isset($_SESSION['user_id'])): ?>
                                <?php $reg_status = getRegistrationStatus($_SESSION['user_id'], $event['event_id']); ?>
                                <?php if ($reg_status === 'pending'): ?>
                                    <div class="bg-orange-500/10 p-4 rounded-2xl border border-orange-500/20 text-center space-y-3">
                                        <p class="text-orange-400 font-bold text-sm italic tracking-wide">⏳ กำลังรอการอนุมัติ... </p>
                                        <?php if (!$isPast): ?>
                                            <form action="/cancel-join" method="post" id="form-cancel-join">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                                <button type="button" class="btn-confirm-cancel text-xs text-[#EEEEEE]/30 hover:text-red-400 underline">ยกเลิกคำขอเข้าร่วม</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($reg_status === 'approved'): ?>
                                    <div class="space-y-3">
                                        <div class="bg-[#00ADB5]/10 p-4 rounded-2xl border border-[#00ADB5]/20 text-center"><p class="text-[#00ADB5] font-bold">✅ อนุมัติแล้ว!</p></div>
                                        <?php if (!$isPast): ?>
                                            <form action="/otp-user" method="post">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                                <button type="submit" class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold shadow-lg shadow-[#00ADB5]/20 hover:scale-[1.02] active:scale-95 transition-all">แสดงรหัสเข้างาน (OTP)</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($reg_status === 'attended'): ?>
                                    <div class="bg-green-500/10 p-6 rounded-2xl border border-green-500/20 text-center"><p class="text-green-400 font-bold">🎉 เข้าร่วมกิจกรรมแล้ว</p></div>
                                <?php elseif ($reg_status === 'rejected'): ?>
                                    <div class="bg-red-500/10 p-4 rounded-2xl border border-red-500/20 text-center"><p class="text-red-400 font-bold">❌ ถูกปฏิเสธคำขอ</p></div>
                                <?php else: ?>
                                    <?php if (!$isPast): ?>
                                        <?php if ($is_full): ?>
                                            <div class="w-full py-5 bg-red-500/10 text-red-400 text-center rounded-[2rem] font-bold text-lg border border-red-500/20 cursor-not-allowed">ผู้เข้าร่วมเต็มจำนวนแล้ว</div>
                                        <?php else: ?>
                                            <form action="/join-event" method="post" id="join-event-form">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                                <button type="button" id="btn-join" class="w-full py-5 bg-[#00ADB5] text-[#222831] rounded-[2rem] font-bold text-xl hover:scale-[1.02] transition-all shadow-xl shadow-[#00ADB5]/20">เข้าร่วมกิจกรรม</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="/login" class="block w-full py-4 border-2 border-[#393E46] text-[#EEEEEE] text-center rounded-2xl font-bold hover:bg-[#393E46] transition-all font-sans">เข้าสู่ระบบเพื่อเข้าร่วม</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php endif; ?>
    </main>

    <?php include 'footer.php' ?>

    <script>
        // รวมการตั้งค่าพื้นฐาน (ถ้าใน header ใช้ MySwal หรือชื่ออื่น ให้แก้ตามนั้นครับ)
        const eventSwal = Swal.mixin({
            background: '#222831',
            color: '#EEEEEE',
            borderRadius: '1.5rem',
            customClass: { popup: 'rounded-[2.5rem] border border-[#EEEEEE]/10 shadow-2xl' }
        });

        // 1. ปุ่มลบกิจกรรม
        document.querySelectorAll('.btn-confirm-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url');
                eventSwal.fire({
                    title: '<span class="text-[#EEEEEE]">ยืนยันการลบ?</span>',
                    text: "ข้อมูลกิจกรรมนี้จะถูกลบถาวร!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#393E46',
                    confirmButtonText: 'ยืนยันการลบ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => { if (result.isConfirmed) window.location.href = url; });
            });
        });

        // 2. ปุ่มยกเลิกคำขอ
        document.querySelectorAll('.btn-confirm-cancel').forEach(btn => {
            btn.addEventListener('click', function() {
                eventSwal.fire({
                    title: '<span class="text-[#EEEEEE]">ยกเลิกคำขอ?</span>',
                    text: "คุณต้องการยกเลิกการลงทะเบียนกิจกรรมนี้ใช่หรือไม่?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00ADB5',
                    cancelButtonColor: '#393E46',
                    confirmButtonText: 'ใช่, ยกเลิกเลย',
                    cancelButtonText: 'กลับ'
                }).then((result) => { if (result.isConfirmed) document.getElementById('form-cancel-join').submit(); });
            });
        });

        // 3. ปุ่มเข้าร่วมกิจกรรม (มี Confirm)
        document.getElementById('btn-join')?.addEventListener('click', function() {
            eventSwal.fire({
                title: '<span class="text-[#EEEEEE]">ยืนยันการเข้าร่วม?</span>',
                html: '<p class="text-[#EEEEEE]/60">ต้องการลงทะเบียนเข้าร่วมกิจกรรม <br><b class="text-[#00ADB5]"><?= htmlspecialchars($event['title']) ?></b> ใช่หรือไม่?</p>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00ADB5',
                cancelButtonColor: '#393E46',
                confirmButtonText: 'ใช่, เข้าร่วมเลย!',
                cancelButtonText: 'ไว้ทีหลัง',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'กำลังดำเนินการ...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }, background: '#222831', color: '#EEEEEE' });
                    document.getElementById('join-event-form').submit();
                }
            });
        });
    </script>
</body>
</html>