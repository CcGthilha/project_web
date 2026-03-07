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
    $stats['gender'][$p['gender']] = ($stats['gender'][$p['gender']] ?? 0) + 1;
    $stats['provinces'][$p['province']] = ($stats['provinces'][$p['province']] ?? 0) + 1;
    $stats['occupations'][$p['occupation']] = ($stats['occupations'][$p['occupation']] ?? 0) + 1;
    
    $age = calculateAge($p['birth_date']);
    if ($age < 20) $stats['ages']['under_20']++;
    elseif ($age <= 30) $stats['ages']['20_30']++;
    else $stats['ages']['30_up']++;
    
    $all_data[] = $p;
}
?>

<html>
<body style="font-family: sans-serif; background: #f4f7f6; padding: 20px;">
    <?php include 'header.php' ?>
    
    <main style="max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h1>📊 <?= htmlspecialchars($data['title']) ?></h1>
        <p>จำนวนผู้สมัครทั้งหมด: <strong><?= $stats['total'] ?></strong> คน</p>
        <hr>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h3>👫 สัดส่วนเพศ</h3>
                <ul>
                    <?php foreach($stats['gender'] as $g => $count): ?>
                        <li><?= $g ?>: <?= $count ?> คน</li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h3>🎂 ช่วงอายุ</h3>
                <ul>
                    <li>ต่ำกว่า 20 ปี: <?= $stats['ages']['under_20'] ?> คน</li>
                    <li>20 - 30 ปี: <?= $stats['ages']['20_30'] ?> คน</li>
                    <li>มากกว่า 30 ปี: <?= $stats['ages']['30_up'] ?> คน</li>
                </ul>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h3>📍 แยกตามจังหวัด</h3>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <tr style="background: #eee;"><th>จังหวัด</th><th>จำนวน (คน)</th></tr>
                <?php foreach($stats['provinces'] as $prov => $count): ?>
                    <tr><td><?= htmlspecialchars($prov) ?></td><td><?= $count ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <h3>💼 แยกตามอาชีพ</h3>
            <p><?php 
                foreach($stats['occupations'] as $occ => $count) {
                    echo htmlspecialchars($occ) . " ($count), ";
                }
            ?></p>
        </div>

        <div style="margin-top: 30px;">
            <a href="/events" style="text-decoration: none; color: #666;">← ย้อนกลับ</a>
        </div>
    </main>
</body>
</html>