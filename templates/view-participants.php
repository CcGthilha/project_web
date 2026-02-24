<html>

<body>
    <?php include 'headermain.php' ?>
    <main style="padding: 20px;">
        <h1><?= htmlspecialchars($data['title']) ?></h1>
        <a href="/events">
            < กลับไปหน้ากิจกรรมของคุณ</a>

                <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background: #eee;">
                            <th>ชื่อ-นามสกุล</th>
                            <th>อีเมล</th>
                            <th>วันที่สมัคร</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($p = $data['participants']->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['email']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($p['registered_at'])) ?></td>
                                <td>
                                    <?php if ($p['status'] === 'pending'): ?>
                                        <span style="color: orange; display: block; margin-bottom: 5px;">รอการตอบรับ</span>

                                        <form action="/approve-participant" method="POST" style="display:inline;">
                                        </form>
                                    <?php else: ?>
                                        <span style="color: <?= $p['status'] === 'approved' ? 'green' : 'red' ?>;">
                                            <?= $p['status'] === 'approved' ? 'ยอมรับแล้ว' : 'ปฏิเสธแล้ว' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($p['status'] === 'pending'): ?>
                                        <form action="/approve-participant" method="POST" style="display:inline;">
                                            <input type="hidden" name="registrations_id" value="<?= $p['registrations_id'] ?>">
                                            <button type="submit" name="action" value="approve" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px;">ยอมรับ</button>
                                            <button type="submit" name="action" value="reject" style="background-color: #ff4d4d; color: white; border: none; padding: 5px 10px; margin-left: 5px;">ปฏิเสธ</button>
                                        </form>
                                    <?php else: ?>
                                        <em>ไม่มีการจัดการ</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
    </main>
</body>

</html>