<?php
// เตรียมตัวแปรเก็บสถิติ
$stats = [
    'total' => 0,
    'gender' => ['ชาย' => 0, 'หญิง' => 0, 'อื่นๆ' => 0],
    'provinces' => [],
    'occupations' => [],
    'ages' => ['under_20' => 0, '20_30' => 0, '30_up' => 0]
];

$all_data = [];
while ($p = $data['participants']->fetch_assoc()) {
    $stats['total']++;

    $g = strtolower(trim($p['gender']));
    if ($g == 'male' || $g == 'ชาย') {
        $stats['gender']['ชาย']++;
    } elseif ($g == 'female' || $g == 'หญิง') {
        $stats['gender']['หญิง']++;
    } else {
        $stats['gender']['อื่นๆ']++;
    }

    // สถิติจังหวัดและอาชีพ
    $prov = trim($p['province']) ?: 'ไม่ระบุ';
    $stats['provinces'][$prov] = ($stats['provinces'][$prov] ?? 0) + 1;

    $occ = trim($p['occupation']) ?: 'ไม่ระบุ';
    $stats['occupations'][$occ] = ($stats['occupations'][$occ] ?? 0) + 1;

    // คำนวณอายุ
    if (isset($p['birth_date'])) {
        $age = calculateAge($p['birth_date']);
        if ($age < 20) $stats['ages']['under_20']++;
        elseif ($age <= 30) $stats['ages']['20_30']++;
        else $stats['ages']['30_up']++;
    }

    $all_data[] = $p;
}

// เรียงลำดับจังหวัดตามจำนวนผู้สมัครจากมากไปน้อย
arsort($stats['provinces']);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <title>สถิติกิจกรรม | Event for you</title>
</head>

<body class="bg-[#222831]">
    <?php include 'header.php' ?>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-[#00ADB5] rounded-2xl flex items-center justify-center shadow-lg shadow-[#00ADB5]/20">
                    <i class="fas fa-chart-pie text-[#222831] text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#EEEEEE]"><?= htmlspecialchars($data['title']) ?></h2>
                    <p class="text-[#EEEEEE]/40 text-sm tracking-wide">ภาพรวมและข้อมูลเชิงลึกของผู้เข้าร่วม</p>
                </div>
            </div>
            <a href="/events" class="text-[#EEEEEE]/30 hover:text-[#00ADB5] transition-all text-sm flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> ย้อนกลับไปหน้าจัดการ
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-gradient-to-br from-[#393E46] to-[#222831] p-8 rounded-[2.5rem] border border-[#00ADB5]/30 shadow-2xl relative overflow-hidden">
                <i class="fas fa-users absolute -right-4 -bottom-4 text-7xl text-[#00ADB5]/5 rotate-12"></i>
                <p class="text-[10px] text-[#00ADB5] uppercase font-bold tracking-[0.2em] mb-2">ผู้เข้าร่วมกิจกรรมทั้งหมด</p>
                <h3 class="text-5xl font-extrabold text-[#EEEEEE]"><?= number_format($stats['total']) ?> <span class="text-lg font-light text-[#EEEEEE]/40">คน</span></h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-[#393E46] p-8 rounded-[3rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#EEEEEE] font-bold mb-8 flex items-center gap-3">
                    <i class="fas fa-venus-mars text-[#00ADB5]"></i> สัดส่วนเพศ (Gender Insight)
                </h3>
                <div class="space-y-6">
                    <?php foreach ($stats['gender'] as $label => $count):
                        $percent = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
                        $color = ($label == 'ชาย') ? '#00ADB5' : (($label == 'หญิง') ? '#F472B6' : '#94A3B8');
                    ?>
                        <div class="space-y-2">
                            <div class="flex justify-between items-end">
                                <span class="text-[#EEEEEE] font-medium"><?= $label ?></span>
                                <span class="text-xs text-[#EEEEEE]/50"><?= $count ?> คน (<?= round($percent, 1) ?>%)</span>
                            </div>
                            <div class="w-full bg-[#222831] h-3 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000"
                                    style="width: <?= $percent ?>%; background-color: <?= $color ?>;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-[#393E46] p-8 rounded-[3rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#EEEEEE] font-bold mb-8 flex items-center gap-3">
                    <i class="fas fa-birthday-cake text-[#00ADB5]"></i> ช่วงอายุ (Age Range)
                </h3>
                <div class="grid grid-cols-1 gap-4">
                    <?php
                    $age_config = [
                        'under_20' => ['label' => 'วัยรุ่น (ต่ำกว่า 20 ปี)', 'icon' => 'fa-child'],
                        '20_30' => ['label' => 'วัยทำงานตอนต้น (20-30 ปี)', 'icon' => 'fa-user-tie'],
                        '30_up' => ['label' => 'ผู้ใหญ่ (มากกว่า 30 ปี)', 'icon' => 'fa-user-check']
                    ];
                    foreach ($stats['ages'] as $key => $count):
                        $percent = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
                    ?>
                        <div class="flex items-center gap-5 bg-[#222831]/40 p-5 rounded-2xl border border-[#EEEEEE]/5 hover:border-[#00ADB5]/20 transition-colors">
                            <div class="w-12 h-12 bg-[#393E46] rounded-xl flex items-center justify-center text-[#00ADB5]">
                                <i class="fas <?= $age_config[$key]['icon'] ?>"></i>
                            </div>
                            <div class="grow">
                                <p class="text-[#EEEEEE] font-semibold text-sm"><?= $age_config[$key]['label'] ?></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex-1 bg-[#393E46] h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-[#00ADB5]/40 h-full" style="width: <?= $percent ?>%"></div>
                                    </div>
                                    <span class="text-[10px] text-[#00ADB5] font-bold"><?= round($percent) ?>%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[#EEEEEE] font-bold"><?= $count ?></p>
                                <p class="text-[9px] text-[#EEEEEE]/30 uppercase tracking-tighter">รายชื่อ</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-[#393E46] p-8 rounded-[3rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#EEEEEE] font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-map-marker-alt text-[#00ADB5]"></i> อันดับจังหวัด (Top Provinces)
                </h3>
                <div class="space-y-2 max-h-[350px] overflow-y-auto pr-2 scrollbar-hide">
                    <?php $rank = 1;
                    foreach ($stats['provinces'] as $prov => $count): ?>
                        <div class="flex items-center justify-between p-4 bg-[#222831]/30 rounded-2xl border-l-4 border-transparent hover:border-[#00ADB5] transition-all">
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-bold text-[#EEEEEE]/20"><?= str_pad($rank++, 2, '0', STR_PAD_LEFT) ?></span>
                                <span class="text-[#EEEEEE]/80"><?= htmlspecialchars($prov) ?></span>
                            </div>
                            <span class="bg-[#00ADB5]/10 text-[#00ADB5] px-3 py-1 rounded-lg text-xs font-bold"><?= $count ?> คน</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-[#393E46] p-8 rounded-[3rem] border border-[#EEEEEE]/5 shadow-xl">
                <h3 class="text-[#EEEEEE] font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-briefcase text-[#00ADB5]"></i> กลุ่มอาชีพ (Occupations)
                </h3>
                <div class="flex flex-wrap gap-3">
                    <?php foreach ($stats['occupations'] as $occ => $count): ?>
                        <div class="group bg-[#222831] px-5 py-3 rounded-2xl border border-[#393E46] hover:border-[#00ADB5] transition-all cursor-default">
                            <span class="text-[#EEEEEE]/40 text-xs block mb-1 group-hover:text-[#00ADB5]/50 transition-colors"><?= htmlspecialchars($occ) ?></span>
                            <span class="text-[#EEEEEE] font-bold text-lg"><?= $count ?> <small class="text-[10px] font-normal opacity-30">คน</small></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>