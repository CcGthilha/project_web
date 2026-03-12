<!DOCTYPE html>
<html lang="th">

<head>
  <title>เข้าสู่ระบบ | Event for you</title>
</head>

<body class="bg-[#222831]">
  <?php include 'header.php' ?>

  <main class="min-h-[85vh] flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-80 h-80 bg-[#00ADB5]/5 rounded-full blur-[100px] -mr-40 -mt-40"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500/5 rounded-full blur-[100px] -ml-40 -mb-40"></div>

    <div class="max-w-md w-full bg-[#393E46] rounded-[3rem] p-8 md:p-12 shadow-2xl border border-[#EEEEEE]/5 relative z-10">
      <div class="text-center mb-10">
        <div class="w-20 h-20 bg-[#222831] rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner border border-[#00ADB5]/20">
          <i class="fas fa-fingerprint text-[#00ADB5] text-3xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-[#EEEEEE] tracking-tight">ยินดีต้อนรับกลับมา</h2>
        <p class="text-[#EEEEEE]/40 text-sm mt-2">เข้าสู่ระบบเพื่อจัดการกิจกรรมของคุณ</p>
      </div>

      <?php if (!empty($data['error'])): ?>
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-2xl text-sm mb-8 flex items-center gap-3 animate-shake">
          <i class="fas fa-exclamation-circle"></i>
          <?= htmlspecialchars($data['error']) ?>
        </div>
      <?php endif; ?>

      <form action="login" method="post" class="space-y-6">
        <div class="space-y-2">
          <label for="email" class="text-xs text-[#EEEEEE]/50 ml-2 font-bold uppercase tracking-widest">อีเมลผู้ใช้</label>
          <div class="relative group">
            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#EEEEEE]/20 group-focus-within:text-[#00ADB5] transition-colors"></i>
            <input type="email" name="email" id="email" required
              class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-4 pl-12 pr-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] focus:ring-1 focus:ring-[#00ADB5] transition-all placeholder:text-[#EEEEEE]/10"
              placeholder="example@mail.com">
          </div>
        </div>

        <div class="space-y-2">
          <!-- <div class="flex justify-between items-center px-2">
            <label for="password" class="text-xs text-[#EEEEEE]/50 font-bold uppercase tracking-widest">รหัสผ่าน</label>
            <a href="#" class="text-[10px] text-[#00ADB5] hover:underline">ลืมรหัสผ่าน?</a>
          </div> -->
          <div class="relative group">
            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#EEEEEE]/20 group-focus-within:text-[#00ADB5] transition-colors"></i>
            <input type="password" name="password" id="password" required
              class="w-full bg-[#222831] border border-[#393E46] rounded-2xl py-4 pl-12 pr-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] focus:ring-1 focus:ring-[#00ADB5] transition-all placeholder:text-[#EEEEEE]/10"
              placeholder="••••••••">
          </div>
        </div>

        <button type="submit"
          class="w-full py-4 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-lg hover:shadow-[0_15px_30px_rgba(0,173,181,0.3)] hover:scale-[1.02] active:scale-95 transition-all mt-4 flex items-center justify-center gap-2">
          <span>เข้าสู่ระบบ</span>
          <i class="fas fa-arrow-right text-sm"></i>
        </button>
      </form>

      <div class="mt-10 text-center">
        <p class="text-[#EEEEEE]/30 text-sm">
          ยังไม่มีบัญชีใช่หรือไม่?
          <a href="/signup" class="text-[#00ADB5] font-bold hover:underline ml-1">สมัครสมาชิกที่นี่</a>
        </p>
      </div>
    </div>
  </main>

  <?php include 'footer.php' ?>
</body>

</html>