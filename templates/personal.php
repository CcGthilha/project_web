<html>

<head></head>

<body>
    <?php include 'headermain.php' ?>
    <main>
    <?php while ($row = $data['result']->fetch_object()): ?>
        <?= $row->name ?>
        <?= $row->email ?>
        <?= $row->gender ?>
        <?= $row->birth_date ?>
        <?= $row->province ?>
        <?= $row->occupation ?>
        <?= $row->created_at ?>
    <?php endwhile; ?>
</main>
    <?php include 'footer.php' ?>
</body>

</html>