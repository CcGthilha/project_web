<!DOCTYPE html>
<html lang="th">

<head>
  <title><?= htmlspecialchars($data['title']) ?> | Event for you</title>
</head>

<body class="bg-[#222831]">
  <?php include 'header.php' ?>

  <main class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20">
          <i class="fas fa-tasks text-[#222831] text-xl"></i>
        </div>
        <div>
          <h2 class="text-3xl font-bold text-[#EEEEEE] tracking-tight"><?= htmlspecialchars($data['title']) ?></h2>
          <p class="text-[#EEEEEE]/40 text-sm font-light font-sans">จัดการและติดตามสถานะกิจกรรมที่คุณสร้างขึ้น</p>
        </div>
      </div>
      <a href="/create-event" class="w-full md:w-auto px-8 py-4 bg-[#00ADB5] text-[#222831] rounded-[2rem] font-bold text-lg hover:shadow-[0_10px_30px_rgba(0,173,181,0.3)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2 font-sans">
        <i class="fas fa-plus-circle"></i> สร้างกิจกรรมใหม่
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php if (!empty($data['events'])): ?>
        <?php foreach ($data['events'] as $event):
          $now = new DateTime();
          $endDate = new DateTime($event['end_date']);
          $isPast = ($endDate < $now);

          // 🌟 โค้ดใหม่: นับคนรออนุมัติ (pending) เฉพาะของกิจกรรมนี้ 🌟
          $pending_count = getPendingCount($event['event_id']);
        ?>
          <div class="group bg-[#393E46] rounded-[2.5rem] overflow-hidden border border-[#EEEEEE]/5 hover:border-[#00ADB5]/30 transition-all duration-500 shadow-xl flex flex-col <?= $isPast ? 'opacity-75' : '' ?>">
            <div class="relative h-52 overflow-hidden">
              <img src="<?= $event['image_path'] ?: 'path/to/default.jpg' ?>"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 <?= $isPast ? 'grayscale' : '' ?>">
              <div class="absolute inset-0 bg-gradient-to-t from-[#393E46] via-transparent to-transparent"></div>

              <div class="absolute top-4 left-4">
                <?php if ($isPast): ?>
                  <span class="bg-[#222831]/80 backdrop-blur-md text-[#EEEEEE]/40 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest font-sans">สิ้นสุดแล้ว</span>
                <?php endif; ?>
              </div>

              <div class="absolute top-4 right-4 flex gap-2">
                <a href="/edit-event?id=<?= $event['event_id'] ?>"
                  class="w-10 h-10 bg-[#222831]/80 backdrop-blur-md text-[#EEEEEE] rounded-xl flex items-center justify-center hover:bg-[#00ADB5] hover:text-[#222831] transition-all" title="แก้ไข">
                  <i class="fas fa-edit text-xs"></i>
                </a>
                <a href="#"
                  data-url="/delete-event?id=<?= $event['event_id'] ?>"
                  data-title="<?= htmlspecialchars($event['title']) ?>"
                  class="btn-delete-event w-10 h-10 bg-red-500/20 backdrop-blur-md text-red-400 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"
                  title="ลบ">
                  <i class="fas fa-trash-alt text-xs"></i>
                </a>
              </div>
            </div>

            <div class="p-8 flex-grow flex flex-col font-sans">
              <h3 class="text-xl font-bold text-[#EEEEEE] mb-4 line-clamp-1 group-hover:text-[#00ADB5] transition-colors">
                <?= htmlspecialchars($event['title']) ?>
              </h3>

              <div class="space-y-3 mb-8 grow">
                <div class="flex items-center gap-3 text-sm text-[#EEEEEE]/50">
                  <i class="fas fa-map-marker-alt text-[#00ADB5] w-4"></i>
                  <span class="truncate"><?= htmlspecialchars($event['location']) ?></span>
                </div>
                <div class="flex items-center gap-3 text-sm text-[#EEEEEE]/50">
                  <i class="fas fa-calendar-alt text-[#00ADB5] w-4"></i>
                  <span><?= date('j M Y', strtotime($event['start_date'])) ?> น.</span>
                </div>
              </div>

              <div class="flex flex-col gap-3">
                <div class="grid grid-cols-2 gap-3">
                  <a href="/view-participants?id=<?= $event['event_id'] ?>"
                    class="relative py-3 bg-[#222831] text-[#EEEEEE] text-center rounded-2xl font-bold text-xs border border-[#EEEEEE]/5 hover:border-[#00ADB5]/50 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-users-cog"></i> ผู้สมัคร

                    <?php if ($pending_count > 0): ?>
                      <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full animate-pulse shadow-lg shadow-red-500/50">
                        <?= $pending_count > 99 ? '99+' : $pending_count ?>
                      </span>
                    <?php endif; ?>
                  </a>

                  <a href="/event-stats?id=<?= $event['event_id'] ?>"
                    class="py-3 bg-[#222831] text-[#EEEEEE]/60 text-center rounded-2xl font-bold text-xs border border-[#EEEEEE]/5 hover:text-[#00ADB5] transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-chart-line"></i> สถิติ
                  </a>
                </div>

                <?php if (!$isPast): ?>
                  <form action="/verify-otp" method="post">
                    <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                    <button type="submit"
                      class="w-full py-3.5 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-sm shadow-lg shadow-[#00ADB5]/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                      <i class="fas fa-qrcode"></i> ตรวจรหัสเข้างาน (OTP)
                    </button>
                  </form>
                <?php else: ?>
                  <div class="w-full py-3.5 bg-[#222831]/30 text-[#EEEEEE]/20 text-center rounded-2xl font-bold text-sm border border-[#EEEEEE]/5 cursor-default">
                    ปิดการลงทะเบียนแล้ว
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-span-full py-24 text-center bg-[#393E46]/30 border-2 border-dashed border-[#EEEEEE]/5 rounded-[3rem]">
          <div class="w-24 h-24 bg-[#393E46] rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
            <i class="fas fa-calendar-plus text-[#EEEEEE]/10 text-4xl"></i>
          </div>
          <h3 class="text-[#EEEEEE] font-bold text-2xl mb-2 font-sans">ยังไม่มีกิจกรรมที่คุณสร้างไว้</h3>
          <a href="/create-event" class="inline-flex items-center gap-2 text-[#00ADB5] font-bold text-lg hover:underline font-sans">
            <i class="fas fa-plus"></i> เพิ่มกิจกรรมแรกของคุณ
          </a>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <?php include 'footer.php' ?>
  <script>
document.querySelectorAll('.btn-delete-event').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('data-url');
        const title = this.getAttribute('data-title');

        Swal.fire({
            title: '<span class="text-[#EEEEEE]">ลบกิจกรรม?</span>',
            html: `<p class="text-[#EEEEEE]/60">คุณแน่ใจหรือไม่ที่จะลบกิจกรรม <br><b class="text-red-400">${title}</b> <br>ข้อมูลผู้สมัครทั้งหมดจะหายไปและกู้คืนไม่ได้!</p>`,
            icon: 'warning',
            iconColor: '#ef4444',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // สีแดงสำหรับการลบ
            cancelButtonColor: '#393E46',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก',
            background: '#222831',
            color: '#EEEEEE',
            borderRadius: '1.5rem',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2.5rem] border border-[#EEEEEE]/10 shadow-2xl',
                confirmButton: 'px-6 py-3 rounded-xl font-bold',
                cancelButton: 'px-6 py-3 rounded-xl font-bold'
            },
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // แสดง Loading ระหว่างลบ
                Swal.fire({
                    title: 'กำลังลบข้อมูล...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    background: '#222831',
                    color: '#EEEEEE'
                });
                window.location.href = url;
            }
        });
    });
});
</script>

</body>

</html>