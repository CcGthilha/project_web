<!DOCTYPE html>
<html lang="th">

<head>
    <title>ข้อมูลส่วนตัว | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="mb-10 flex items-center gap-4">
            <div class="w-12 h-12 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20">
                <i class="fas fa-user-shield text-[#222831] text-xl"></i>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-[#EEEEEE]">ข้อมูลส่วนตัว</h2>
                <p class="text-[#EEEEEE]/50 text-sm font-light">จัดการข้อมูลพื้นฐานและบัญชีของคุณ</p>
            </div>
        </div>

        <?php while ($row = $data['result']->fetch_object()): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="md:col-span-1">
                    <div class="bg-[#393E46] p-8 rounded-[2.5rem] border border-[#EEEEEE]/5 text-center shadow-xl">
                        <div class="relative inline-block mb-4">
                            <div class="w-32 h-32 rounded-full bg-[#222831] border-4 border-[#00ADB5] flex items-center justify-center mx-auto overflow-hidden">
                                <i class="fas fa-user text-5xl text-[#00ADB5]"></i>
                            </div>
                        </div>
                        <h3 class="text-[#EEEEEE] font-bold text-xl"><?= htmlspecialchars($row->name) ?></h3>
                        <p class="text-[#00ADB5] text-sm mt-1"><?= htmlspecialchars($row->occupation) ?></p>

                        <div class="mt-8 pt-6 border-t border-[#EEEEEE]/5">
                            <a href="/chpw?id=<?= $row->user_id ?>"
                                class="flex items-center justify-center gap-2 w-full py-3 bg-[#222831] text-[#00ADB5] rounded-xl font-bold border border-[#00ADB5]/30 hover:bg-[#00ADB5] hover:text-[#222831] transition-all">
                                <i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน
                            </a>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-[#393E46] p-8 md:p-10 rounded-[2.5rem] border border-[#EEEEEE]/5 shadow-xl h-full">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-8">

                            <div class="space-y-1">
                                <label class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-[0.2em]">อีเมล</label>
                                <p class="text-[#EEEEEE] text-lg font-medium border-b border-[#EEEEEE]/5 pb-2">
                                    <?= htmlspecialchars($row->email) ?>
                                </p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-[0.2em]">เพศ</label>
                                <p class="text-[#EEEEEE] text-lg font-medium border-b border-[#EEEEEE]/5 pb-2">
                                    <?= htmlspecialchars($row->gender) ?>
                                </p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-[0.2em]">วันเกิด</label>
                                <p class="text-[#EEEEEE] text-lg font-medium border-b border-[#EEEEEE]/5 pb-2">
                                    <?= date('d F Y', strtotime($row->birth_date)) ?>
                                </p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-[0.2em]">จังหวัด</label>
                                <p class="text-[#EEEEEE] text-lg font-medium border-b border-[#EEEEEE]/5 pb-2">
                                    <?= htmlspecialchars($row->province) ?>
                                </p>
                            </div>

                        </div>

                        <div class="mt-12 p-6 bg-[#222831]/50 rounded-3xl border border-[#00ADB5]/10 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#00ADB5]/20 rounded-full flex items-center justify-center text-[#00ADB5]">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[#EEEEEE] text-sm font-bold">บัญชีของคุณปลอดภัย</p>
                                    <p class="text-[#EEEEEE]/40 text-xs font-light">ข้อมูลส่วนตัวจะไม่ถูกเปิดเผยต่อสาธารณะ</p>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-[#00ADB5] text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>
        <?php endwhile; ?>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>