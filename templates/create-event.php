<!DOCTYPE html>
<html lang="th">
<!-- /templates/create-event.php -->

<head>
    <title>สร้างกิจกรรมใหม่ | Event for you</title>

</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-3xl mx-auto px-4 py-12">
        <div class="mb-10 text-center">
            <div class="w-16 h-16 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20 mx-auto mb-4">
                <i class="fas fa-calendar-plus text-[#222831] text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-[#EEEEEE]"><?= $data['title'] ?? 'สร้างกิจกรรมใหม่' ?></h1>
            <p class="text-[#EEEEEE]/50 mt-2">กรอกรายละเอียดกิจกรรมของคุณให้ครบถ้วนเพื่อเริ่มรับลงทะเบียน</p>
        </div>

        <form action="/create-event" method="POST" enctype="multipart/form-data" class="space-y-8">

            <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#00ADB5] font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fas fa-image"></i> รูปภาพกิจกรรม
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="cover_image" class="text-xs text-[#EEEEEE]/50 ml-2">รูปภาพหน้าปก (1 รูป)*</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" required
                            class="w-full bg-[#222831] text-[#EEEEEE] border border-[#393E46] rounded-xl p-2 focus:outline-none focus:border-[#00ADB5] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#00ADB5] file:text-[#222831] hover:file:opacity-80 cursor-pointer">
                    </div>
                    <div class="space-y-2">
                        <label for="gallery_images" class="text-xs text-[#EEEEEE]/50 ml-2">รูปภาพเพิ่มเติม (เลือกได้หลายรูป)</label>
                        <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple
                            class="w-full bg-[#222831] text-[#EEEEEE] border border-[#393E46] rounded-xl p-2 focus:outline-none focus:border-[#00ADB5] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#393E46] file:text-[#EEEEEE] hover:file:bg-[#4a515a] cursor-pointer">
                    </div>
                </div>
            </div>

            <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#00ADB5] font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> ข้อมูลพื้นฐาน
                </h3>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label for="title" class="text-xs text-[#EEEEEE]/50 ml-2">ชื่อกิจกรรม*</label>
                        <input type="text" id="title" name="title" placeholder="เช่น Workshop การเขียนโปรแกรมเบื้องต้น" required
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 px-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition">
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="text-xs text-[#EEEEEE]/50 ml-2">รายละเอียดกิจกรรม*</label>
                        <textarea id="description" name="description" rows="5" placeholder="อธิบายเกี่ยวกับกิจกรรมนี้เพื่อให้คนสนใจ..." required
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 px-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition resize-none"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="location" class="text-xs text-[#EEEEEE]/50 ml-2">สถานที่จัดงาน*</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-5 top-1/2 -translate-y-1/2 text-[#00ADB5]"></i>
                            <input type="text" id="location" name="location" placeholder="เช่น อาคาร A ห้อง 101 หรือ ออนไลน์" required
                                class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 pl-12 pr-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="max_participants" class="text-xs text-[#EEEEEE]/50 ml-2">จำนวนผู้เข้าร่วมสูงสุด (ระบุ 0 หากไม่จำกัด)*</label>
                        <div class="relative">
                            <i class="fas fa-users absolute left-5 top-1/2 -translate-y-1/2 text-[#00ADB5]"></i>
                            <input type="number" id="max_participants" name="max_participants" min="0" max="99999" value="0" required
                                class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 pl-12 pr-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#00ADB5] font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fas fa-clock"></i> กำหนดการ
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="start_date" class="text-xs text-[#EEEEEE]/50 ml-2">วันและเวลาเริ่มงาน*</label>
                        <input type="datetime-local" id="start_date" name="start_date" required
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 px-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition">
                    </div>
                    <div class="space-y-2">
                        <label for="end_date" class="text-xs text-[#EEEEEE]/50 ml-2">วันและเวลาสิ้นสุดงาน*</label>
                        <input type="datetime-local" id="end_date" name="end_date" required
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 px-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition">
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="w-full py-5 bg-[#00ADB5] text-[#222831] rounded-[1.5rem] font-bold text-xl hover:shadow-[0_15px_35px_rgba(0,173,181,0.3)] hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">
                    <i class="fas fa-plus-circle"></i> ยืนยันการสร้างกิจกรรม
                </button>
                <p class="text-center text-[#EEEEEE]/30 text-xs mt-4">เมื่อกดสร้าง กิจกรรมของคุณจะแสดงให้ผู้ใช้อื่นเห็นทันที</p>
            </div>
        </form>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>