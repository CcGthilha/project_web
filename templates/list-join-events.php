<!DOCTYPE html>
<html lang="th">

<head>
    <title>กิจกรรมที่เข้าร่วม | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20 font-sans">
                    <i class="fas fa-clipboard-list text-[#222831] text-xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#EEEEEE] tracking-tight font-sans"><?= htmlspecialchars($data['title']) ?></h2>
                    <p class="text-[#EEEEEE]/40 text-sm font-light font-sans">จัดการสถานะและรับรหัสเข้างานของคุณ</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 mb-12 bg-[#393E46]/30 p-2 rounded-[2rem] w-fit border border-[#EEEEEE]/5">
            <?php
            $current_status = $_GET['status'] ?? 'all';
            $tabs = ['all' => 'ทั้งหมด', 'approved' => 'อนุมัติแล้ว', 'pending' => 'รออนุมัติ', 'rejected' => 'ถูกปฏิเสธ'];
            foreach ($tabs as $key => $label):
                $isActive = ($current_status === $key);
            ?>
                <a href="?status=<?= $key ?>"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition-all font-sans <?= $isActive ? 'bg-[#00ADB5] text-[#222831] shadow-lg shadow-[#00ADB5]/20' : 'text-[#EEEEEE]/50 hover:text-[#EEEEEE]' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($data['result']->num_rows > 0): ?>
                <?php while ($row = $data['result']->fetch_assoc()):
                    $now = new DateTime();
                    $endDate = new DateTime($row['end_date']);
                    $isPast = ($endDate < $now);
                ?>
                    <div class="group bg-[#393E46] rounded-[2.5rem] overflow-hidden border border-[#EEEEEE]/5 hover:border-[#00ADB5]/30 transition-all duration-500 shadow-xl flex flex-col <?= $isPast ? 'opacity-70' : '' ?>">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?= $row['image_path'] ?: 'path/to/default.jpg' ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 <?= $isPast ? 'grayscale' : '' ?>">
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <?php if ($isPast): ?>
                                    <span class="bg-[#222831]/80 backdrop-blur-md text-[#EEEEEE]/40 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider">สิ้นสุดกิจกรรมแล้ว</span>
                                <?php endif; ?>
                                <?php if ($row['join_status'] == 'approved'): ?>
                                    <span class="bg-green-500 text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-lg">✅ อนุมัติแล้ว</span>
                                <?php elseif ($row['join_status'] == 'pending'): ?>
                                    <span class="bg-orange-500 text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-lg font-sans">⏳ รออนุมัติ</span>
                                <?php elseif ($row['join_status'] == 'rejected'): ?>
                                    <span class="bg-red-500 text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-lg font-sans">❌ ถูกปฏิเสธ</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-8 flex-grow flex flex-col font-sans">
                            <h3 class="text-xl font-bold text-[#EEEEEE] mb-4 line-clamp-1 group-hover:text-[#00ADB5] transition-colors"><?= htmlspecialchars($row['title']) ?></h3>
                            <div class="space-y-3 mb-8 grow">
                                <p class="text-sm text-[#EEEEEE]/40 font-light"><i class="fas fa-user-tie text-[#00ADB5] mr-2"></i> ผู้จัด: <?= htmlspecialchars($row['creator_name']) ?></p>
                                <p class="text-sm text-[#EEEEEE]/40 font-light"><i class="fas fa-calendar-alt text-[#00ADB5] mr-2"></i> <?= date('j M Y', strtotime($row['start_date'])) ?></p>
                            </div>

                            <div class="flex flex-col gap-3">
                                <a href="/event-detail?event_id=<?= $row['event_id'] ?>" class="w-full py-3 bg-[#222831] text-[#EEEEEE]/60 text-center rounded-2xl font-bold text-sm border border-[#EEEEEE]/5 hover:text-[#EEEEEE] transition-all">ดูรายละเอียด</a>

                                <?php if ($row['join_status'] == 'approved' && !$isPast): ?>
                                    <form action="/otp-user" method="POST">
                                        <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                                        <button type="submit" class="w-full py-3.5 bg-[#00ADB5] text-[#222831] rounded-2xl font-bold text-sm shadow-lg shadow-[#00ADB5]/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                                            <i class="fas fa-key"></i> แสดงรหัสเข้างาน (OTP)
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-24 text-center bg-[#393E46]/30 border-2 border-dashed border-[#EEEEEE]/5 rounded-[3rem]">
                    <h3 class="text-[#EEEEEE]/30 font-sans">ไม่พบรายการกิจกรรม</h3>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>