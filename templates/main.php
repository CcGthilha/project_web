<?php
// 1. ตั้งค่า Timezone ให้ตรงกับเวลาไทย (ป้องกัน Live Now ไม่ขึ้น)
date_default_timezone_set('Asia/Bangkok');
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <title>ค้นหากิจกรรม | Event for you</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .filter-transition {
      transition: all 0.3s ease-in-out;
    }
  </style>
</head>

<body class="bg-[#222831]">
  <?php include 'header.php' ?>

  <main class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
      <div class="space-y-2">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#EEEEEE] tracking-tight">
          สำรวจ <span class="text-[#00ADB5]">กิจกรรม</span>
        </h1>
        <p class="text-[#EEEEEE]/40 font-light">ค้นพบประสบการณ์ใหม่ๆ ที่สร้างมาเพื่อคุณโดยเฉพาะ</p>
      </div>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/create-event" class="px-8 py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold shadow-lg shadow-[#00ADB5]/20 hover:scale-105 transition-all flex items-center gap-2">
          <i class="fas fa-plus-circle"></i> สร้างกิจกรรม
        </a>
      <?php endif; ?>
    </div>

    <section class="bg-[#393E46] p-6 rounded-[2.5rem] border border-[#EEEEEE]/5 mb-12 shadow-xl">
      <form action="/search" method="get" class="space-y-4">
        <div class="flex flex-col md:flex-row gap-4">
          <div class="relative flex-1">
            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-[#00ADB5]"></i>
            <input type="text" name="keyword"
              class="w-full bg-[#222831] border border-[#EEEEEE]/5 rounded-2xl py-4 pl-14 pr-4 text-[#EEEEEE] focus:border-[#00ADB5] outline-none transition-all placeholder:text-[#EEEEEE]/20"
              value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
              placeholder="พิมพ์ชื่อกิจกรรมที่ต้องการค้นหา...">
          </div>

          <button type="button" onclick="toggleFilter()"
            class="px-6 py-4 bg-[#222831] text-[#EEEEEE]/60 rounded-2xl border border-[#EEEEEE]/5 hover:text-[#00ADB5] transition-all flex items-center gap-2">
            <i class="fas fa-calendar-alt"></i> เลือกช่วงเวลา
          </button>

          <button type="submit" class="px-10 py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold hover:shadow-[0_0_20px_rgba(0,173,181,0.3)] transition-all">
            ค้นหา
          </button>

          <?php if (!empty($_GET['keyword']) || !empty($_GET['start_date']) || !empty($_GET['end_date'])): ?>
            <a href="/main" class="px-6 py-4 bg-red-500/10 text-red-400 rounded-2xl flex items-center justify-center border border-red-500/20 hover:bg-red-500 hover:text-white transition-all">
              <i class="fas fa-times"></i>
            </a>
          <?php endif; ?>
        </div>

        <div id="date-filter" class="hidden overflow-hidden filter-transition border-t border-[#EEEEEE]/5 pt-4 mt-4">
          <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1 space-y-2">
              <label class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest ml-2">จากวันที่</label>
              <input type="date" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>"
                class="w-full bg-[#222831] border border-[#EEEEEE]/5 rounded-xl py-3 px-4 text-[#EEEEEE] [color-scheme:dark]">
            </div>
            <div class="flex-1 space-y-2">
              <label class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-widest ml-2">ถึงวันที่</label>
              <input type="date" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>"
                class="w-full bg-[#222831] border border-[#EEEEEE]/5 rounded-xl py-3 px-4 text-[#EEEEEE] [color-scheme:dark]">
            </div>
          </div>
        </div>
      </form>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
      <?php
      $res_upcoming = $data['upcoming'] ?? null;
      if ($res_upcoming && $res_upcoming->num_rows > 0):
        while ($row = $res_upcoming->fetch_assoc()):
          // 2. แก้ไขส่วนเวลาตรงนี้
          $now = new DateTime(); // เวลาปัจจุบัน (อิงตาม timezone ที่เซตไว้)
          $start = new DateTime($row['start_date']);
          $end = new DateTime($row['end_date']);

          // Logic: ถ้าเวลาปัจจุบันอยู่ระหว่างเริ่มและจบ ให้เป็น Live
          $is_live = ($now >= $start && $now <= $end);
          $is_past = ($now > $end);

<<<<<<< HEAD
          /*var_dump([
            'now' => $now->format('Y-m-d H:i:s'),
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
            'is_live' => ($now >= $start && $now <= $end)
          ]);*/

=======
>>>>>>> 29e4f9e9c3e125b53c7051a977d0773a9e1c994f
          // 🌟 โค้ดเดิมของคุณ: ดึงตัวเลขรับสมัครออกจาก Description
          // 1. เรียกใช้โรงงานสกัดข้อมูล (ฟังก์ชันชุดที่ 1)
          
          $parsed_data = parseEventDescription($row['description']);

          // 2. เอาข้อมูลที่สกัดแล้วมาใช้ต่อได้เลย
          $max_limit_main = $parsed_data['max_limit'];
          $clean_description = $parsed_data['clean_desc']; // เอาตัวนี้ไปโชว์หน้าเว็บนะ โค้ดลับจะได้ไม่โผล่!

          // 3. เช็คสถานะคนเต็ม (โค้ดเดิมของคุณ)
          $current_joined_main = getParticipantCount($row['event_id']);
          $is_full_main = ($max_limit_main > 0 && $current_joined_main >= $max_limit_main);
      ?>
          <div class="group bg-[#393E46] rounded-[2.5rem] overflow-hidden border border-[#EEEEEE]/5 hover:border-[#00ADB5]/30 transition-all duration-500 shadow-xl flex flex-col <?= $is_past ? 'opacity-60 grayscale-[0.5]' : '' ?>">

            <div class="relative h-48 overflow-hidden">
              <img src="<?= $row['image_path'] ?: '/public/default.jpg' ?>"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 <?= $is_past ? 'filter grayscale' : '' ?>">

              <div class="absolute top-4 left-4">
                <?php if ($is_past): ?>
                  <span class="bg-[#222831]/90 backdrop-blur-md text-[#EEEEEE]/50 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border border-[#EEEEEE]/10">กิจกรรมจบแล้ว</span>
                <?php elseif ($is_live): ?>
                  <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider animate-pulse shadow-lg shadow-red-500/20 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span> LIVE NOW
                  </span>
                <?php endif; ?>
              </div>
            </div>

            <div class="p-6 flex flex-col flex-grow">
              <div class="flex items-center gap-2 text-[#00ADB5] text-[10px] font-bold uppercase tracking-widest mb-3">
                <i class="far fa-calendar-alt"></i>
                <span><?= date('j M Y', strtotime($row['start_date'])) ?></span>
              </div>

              <h3 class="text-lg font-bold text-[#EEEEEE] mb-2 line-clamp-1 group-hover:text-[#00ADB5] transition-colors">
                <?= htmlspecialchars($row['title']) ?>
              </h3>

              <div class="text-xs text-[#EEEEEE]/40 mb-6 flex justify-between items-center w-full">
                <span class="flex items-center gap-1">
                  <i class="far fa-user"></i> โดย: <?= htmlspecialchars($row['name']) ?>
                </span>

                <span class="<?= $is_full_main ? 'bg-red-500/10 text-red-400' : 'bg-[#00ADB5]/10 text-[#00ADB5]' ?> px-2 py-1 rounded-md font-bold text-[10px]">
                  <i class="fas fa-users"></i>
                  <?= $current_joined_main ?> / <?= $max_limit_main == 0 ? 'ไม่จำกัด' : $max_limit_main ?>
                  <?= $is_full_main ? ' (เต็ม)' : '' ?>
                </span>
              </div>

              <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): ?>
                <?php $reg_status = getRegistrationStatus($_SESSION['user_id'], $row['event_id']); ?>
                <?php if ($reg_status): ?>
                  <div class="mb-4 text-center py-2 bg-[#222831]/50 rounded-xl border border-[#EEEEEE]/5">
                    <?php if ($reg_status === 'pending'): ?>
                      <span class="text-orange-400 text-[10px] font-bold uppercase">⏳ รอการอนุมัติ</span>
                    <?php elseif ($reg_status === 'approved'): ?>
                      <span class="text-[#00ADB5] text-[10px] font-bold uppercase">✅ อนุมัติแล้ว</span>
                    <?php elseif ($reg_status === 'attended'): ?>
                      <span class="text-green-500 text-[10px] font-bold uppercase">🎉 เข้าร่วมแล้ว</span>
                    <?php elseif ($reg_status === 'rejected'): ?>
                      <span class="text-red-500 text-[10px] font-bold uppercase">❌ ถูกปฏิเสธ</span>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>

              <div class="mt-auto flex flex-col gap-2">
                <a href="event-detail?event_id=<?= $row['event_id'] ?>"
                  class="w-full py-3 bg-[#222831] text-[#EEEEEE] text-center rounded-xl font-bold text-xs border border-[#EEEEEE]/5 hover:bg-[#393E46] transition-all">
                  รายละเอียด
                </a>

                <?php if (!$is_past && isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id'] && !$reg_status): ?>
                  <?php if ($is_full_main): ?>
                    <div class="w-full py-3 bg-red-500/10 text-red-400 text-center rounded-xl font-bold text-xs border border-red-500/20 cursor-not-allowed">
                      <i class="fas fa-users-slash"></i> กิจกรรมผู้เข้าร่วมเต็มแล้ว
                    </div>
                  <?php else: ?>
                    <form action="/join-event" method="post">
                      <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                      <button type="button"
                        class="btn-join-event w-full py-3 bg-[#00ADB5] text-[#222831] rounded-xl font-bold text-xs hover:shadow-lg shadow-[#00ADB5]/20 transition-all"
                        data-title="<?= htmlspecialchars($row['title']) ?>"> เข้าร่วมกิจกรรม
                      </button>
                    </form>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php
        endwhile;
      else:
        ?>
        <div class="col-span-full py-24 text-center bg-[#393E46]/30 border-2 border-dashed border-[#EEEEEE]/5 rounded-[3rem]">
          <div class="w-20 h-20 bg-[#393E46] rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-search text-[#EEEEEE]/10 text-3xl"></i>
          </div>
          <h3 class="text-[#EEEEEE] font-bold text-xl mb-2">ไม่พบรายการกิจกรรม</h3>
          <p class="text-[#EEEEEE]/30 font-light mb-8">ลองเปลี่ยนคำค้นหาหรือตัวกรองวันที่ดูนะครับ</p>
          <a href="/main" class="text-[#00ADB5] font-bold hover:underline">แสดงกิจกรรมทั้งหมด</a>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <?php include 'footer.php' ?>

  <script>
    function toggleFilter() {
      const filter = document.getElementById('date-filter');
      filter.classList.toggle('hidden');
    }

    // จัดการการแจ้งเตือนยืนยันก่อนเข้าร่วม
    document.querySelectorAll('.btn-join-event').forEach(button => {
      button.addEventListener('click', function() {
        const form = this.closest('form');
        const eventTitle = this.getAttribute('data-title');

        Swal.fire({
          title: '<span class="text-[#EEEEEE]">ยืนยันการเข้าร่วม?</span>',
          html: `<p class="text-[#EEEEEE]/60">คุณต้องการลงทะเบียนเข้าร่วมกิจกรรม <br><b class="text-[#00ADB5]">${eventTitle}</b> ใช่หรือไม่?</p>`,
          icon: 'question',
          iconColor: '#00ADB5',
          showCancelButton: true,
          confirmButtonColor: '#00ADB5',
          cancelButtonColor: '#393E46',
          confirmButtonText: 'ใช่, ฉันต้องการเข้าร่วม!',
          cancelButtonText: 'ยกเลิก',
          background: '#222831',
          color: '#EEEEEE',
          borderRadius: '1.5rem',
          reverseButtons: true,
          customClass: {
            popup: 'rounded-[2.5rem] border border-[#EEEEEE]/10 shadow-2xl',
            confirmButton: 'px-6 py-3 rounded-xl font-bold',
            cancelButton: 'px-6 py-3 rounded-xl font-bold'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: 'กำลังดำเนินการ...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              },
              background: '#222831',
              color: '#EEEEEE'
            });

            form.submit();
          }
        });
      });
    });
  </script>
</body>

</html>