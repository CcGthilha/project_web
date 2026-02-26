<html>

<head></head>

<body>
    <?php include 'header.php' ?>
    <main>
    <?php while ($row = $data['result']->fetch_object()): ?>
        <?= $row->name ?>
        <?= $row->email ?>
        <?= $row->gender ?>
        <?= $row->birth_date ?>
        <?= $row->province ?>
        <?= $row->occupation ?>
        <a href="/chpw?id=<?= $row->user_id ?>">เปลี่ยนรหัสผ่าน</a>
    <?php endwhile; ?>
</main>
    <?php include 'footer.php' ?>
</body>

</html>