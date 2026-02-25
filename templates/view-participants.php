<html>

<body>
    <?php include 'header.php' ?>
    <main style="padding: 20px;">
        <h1><?= htmlspecialchars($data['title']) ?></h1>
        <a href="/events">
            < กลับไปหน้ากิจกรรมของคุณ</a>
                <?php if ($data['participants']->num_rows > 0): ?>
                    <p>รายชื่อผู้เข้าร่วมกิจกรรมนี้:</p>
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
                                            <div style="display: flex; gap: 10px;">

                                                <form action="/approve-participant" method="POST">
                                                    <input type="hidden" name="reg_id" value="<?= $p['registrations_id'] ?>">
                                                    <input type="hidden" name="event_id" value="<?= $p['event_id'] ?>">
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" style="background-color: green; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;">อนุมัติ</button>
                                                </form>

                                                <form action="/approve-participant" method="POST">
                                                    <input type="hidden" name="reg_id" value="<?= $p['registrations_id'] ?>">
                                                    <input type="hidden" name="event_id" value="<?= $p['event_id'] ?>">
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;">ปฏิเสธ</button>
                                                </form>

                                            </div>
                                        <?php else: ?>
                                            <em>ไม่มีการจัดการ</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="color: #888; font-style: italic; text-align: center;">ยังไม่มีผู้เข้าร่วมกิจกรรมนี้</p>
                <?php endif; ?>
    </main>
</body>

</html>