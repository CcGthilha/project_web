<!DOCTYPE html>
<html lang="th">

<head>
    <title>แก้ไขกิจกรรม | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="mb-10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20">
                    <i class="fas fa-edit text-[#222831] text-xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#EEEEEE]">แก้ไขกิจกรรม</h2>
                    <p class="text-[#EEEEEE]/50 text-sm font-light">ปรับปรุงข้อมูลกิจกรรมของคุณให้เป็นปัจจุบัน</p>
                </div>
            </div>
            <a href="/events" class="hidden md:block text-[#EEEEEE]/40 hover:text-[#00ADB5] transition text-sm">
                <i class="fas fa-arrow-left mr-2"></i> ยกเลิกและกลับหน้าเดิม
            </a>
        </div>

        <?php if (isset($data['event'])):
            $row = $data['event'];
            $parsed_desc = parseEventDescription($row['description']);
            $clean_desc = $parsed_desc['clean_desc'];
            $current_max = $parsed_desc['max_limit'];
        ?>
            <form action="/edit-event" method="POST" enctype="multipart/form-data" class="space-y-8">
                <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">

                <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-xl">
                    <h3 class="text-[#00ADB5] font-bold mb-6 flex items-center gap-2">
                        <i class="fas fa-images"></i> จัดการรูปภาพ
                    </h3>

                    <?php
                    // 🌟 ดึงรูปทั้งหมดมาหั่นแยก "รูปปก" กับ "รูปเพิ่มเติม"
                    $all_images = $data['images'] ?? [];
                    $cover_id = null;
                    $cover_path = null;
                    $gallery_images = [];

                    if (!empty($all_images)) {
                        // ดึงรูปแรกสุดออกมาเป็นรูปปก
                        reset($all_images);
                        $cover_id = key($all_images);
                        $cover_path = array_shift($all_images);
                        // ที่เหลือคือรูปเพิ่มเติม
                        $gallery_images = $all_images;
                    }
                    ?>

                    <div class="mb-8">
                        <label class="text-xs text-[#00ADB5] uppercase font-bold tracking-widest block mb-4">รูปปกกิจกรรมปัจจุบัน</label>
                        <?php if ($cover_path): ?>
                            <div class="w-full sm:w-1/2 md:w-1/3 relative group cursor-pointer">
                                <img src="<?= $cover_path ?>" class="w-full aspect-video object-cover rounded-2xl border-4 border-[#00ADB5]/30 group-hover:border-red-500 transition-all shadow-lg">
                                <div class="absolute inset-0 bg-red-500/0 group-hover:bg-red-500/20 rounded-2xl transition-all flex items-center justify-center">
                                    <input type="checkbox" name="delete_images[]" value="<?= $cover_id ?>" class="w-6 h-6 accent-red-500 transform scale-150 shadow-sm">
                                </div>
                                <span class="absolute -top-3 -right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">ลบรูปปก</span>
                            </div>
                            <p class="text-[10px] text-red-400 mt-2">* หากลบรูปปก รูปเพิ่มเติมถัดไปจะกลายเป็นรูปปกแทนโดยอัตโนมัติ</p>
                        <?php else: ?>
                            <p class="text-[#EEEEEE]/20 text-sm italic">ไม่มีรูปปก</p>
                        <?php endif; ?>
                    </div>

                    <label class="text-xs text-[#EEEEEE]/40 uppercase font-bold tracking-widest block mb-4">รูปเพิ่มเติม (เลือกเพื่อลบ)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                        <?php if (!empty($gallery_images)): ?>
                            <?php foreach ($gallery_images as $img_id => $img_path): ?>
                                <label class="relative group cursor-pointer">
                                    <img src="<?= $img_path ?>" class="w-full aspect-square object-cover rounded-2xl border-2 border-transparent group-hover:border-red-500 transition-all">
                                    <div class="absolute inset-0 bg-red-500/0 group-hover:bg-red-500/20 rounded-2xl transition-all flex items-center justify-center">
                                        <input type="checkbox" name="delete_images[]" value="<?= $img_id ?>" class="w-5 h-5 accent-red-500">
                                    </div>
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">ลบ</span>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-[#EEEEEE]/20 text-sm italic col-span-full">ไม่มีรูปเพิ่มเติม</p>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-2 pt-6 border-t border-[#EEEEEE]/10">
                        <label for="new_images" class="text-xs text-[#EEEEEE]/80 font-bold block">อัปโหลดรูปภาพใหม่เพิ่ม <span class="text-[#EEEEEE]/40 font-normal">(สามารถเลือกได้หลายรูป)</span></label>
                        <input type="file" id="new_images" name="new_images[]" accept="image/*" multiple
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3 px-4 text-[#EEEEEE] text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#00ADB5]/10 file:text-[#00ADB5] hover:file:bg-[#00ADB5]/20 cursor-pointer">
                    </div>
                </div>

                <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-xl space-y-6">
                    <h3 class="text-[#00ADB5] font-bold mb-2 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> ข้อมูลรายละเอียด
                    </h3>

                    <div class="space-y-2">
                        <label for="title" class="text-xs text-[#EEEEEE]/50 ml-2">ชื่อกิจกรรม</label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($row['title']) ?>" required
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 px-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition-all"
                            placeholder="ระบุชื่อกิจกรรมของคุณ">
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="text-xs text-[#EEEEEE]/50 ml-2">รายละเอียดกิจกรรม</label>
                        <textarea id="description" name="description" rows="5" required
                            class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 px-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition-all resize-none"
                            placeholder="บรรยายเกี่ยวกับกิจกรรมนี้..."><?= htmlspecialchars($clean_desc) ?></textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="max_participants" class="text-xs text-[#EEEEEE]/50 ml-2">จำนวนผู้เข้าร่วมสูงสุด (ระบุ 0 หากไม่จำกัด)</label>
                        <div class="relative">
                            <i class="fas fa-users absolute left-5 top-1/2 -translate-y-1/2 text-[#00ADB5]"></i>
                            <input type="number" id="max_participants" name="max_participants"
                                min="0" max="99999" value="<?= $current_max ?>" required
                                class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-4 pl-12 pr-5 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="location" class="text-xs text-[#EEEEEE]/50 ml-2">สถานที่จัดงาน</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-[#00ADB5]"></i>
                            <input type="text" id="location" name="location" value="<?= htmlspecialchars($row['location']) ?>" required
                                class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 pl-12 pr-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition-all"
                                placeholder="เช่น ห้องประชุม A, สวนสาธารณะ...">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <div class="space-y-2">
                            <label for="start_date" class="text-xs text-[#EEEEEE]/50 ml-2">วันที่เริ่มกิจกรรม</label>
                            <input type="datetime-local" id="start_date" name="start_date"
                                value="<?= date('Y-m-d\TH:i', strtotime($row['start_date'])) ?>" required
                                class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 px-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition-all [color-scheme:dark]">
                        </div>
                        <div class="space-y-2">
                            <label for="end_date" class="text-xs text-[#EEEEEE]/50 ml-2">วันที่สิ้นสุดกิจกรรม</label>
                            <input type="datetime-local" id="end_date" name="end_date"
                                value="<?= date('Y-m-d\TH:i', strtotime($row['end_date'])) ?>" required
                                class="w-full bg-[#222831] border border-[#393E46] rounded-xl py-3.5 px-4 text-[#EEEEEE] focus:outline-none focus:border-[#00ADB5] transition-all [color-scheme:dark]">
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit"
                        class="w-full py-5 bg-[#00ADB5] text-[#222831] rounded-[2rem] font-bold text-xl hover:shadow-[0_15px_35px_rgba(0,173,181,0.3)] hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-save"></i> บันทึกข้อมูลที่แก้ไข
                    </button>
                    <p class="text-center mt-6">
                        <a href="/events" class="text-[#EEEEEE]/30 text-sm hover:text-red-400 transition">ยกเลิกการแก้ไข</a>
                    </p>
                </div>
            </form>
        <?php else: ?>
            <div class="bg-[#393E46] rounded-[2.5rem] p-20 text-center border border-red-500/20">
                <i class="fas fa-exclamation-triangle text-red-500 text-5xl mb-6"></i>
                <h3 class="text-xl font-bold text-[#EEEEEE]">ไม่พบข้อมูลกิจกรรม</h3>
                <p class="text-[#EEEEEE]/40 mt-2">คุณอาจไม่มีสิทธิ์เข้าถึงหน้านี้ หรือกิจกรรมถูกลบไปแล้ว</p>
                <a href="/events" class="inline-block mt-8 text-[#00ADB5] font-bold hover:underline">กลับไปหน้ากิจกรรมของคุณ</a>
            </div>
        <?php endif; ?>

    </main>

    <?php include 'footer.php' ?>
</body>

</html>