<header>
    <h1>กิจกรรมสร้างได้ด้วยมือเรา</h1>
</header>
<nav style="padding: 15px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">

    <div>
        <a href="/" style="margin-right: 15px; text-decoration: none; font-weight: bold; color: #333;">หน้าแรก</a>
        <a href="/main" style="margin-right: 15px; text-decoration: none; font-weight: bold; color: #333;">กิจกรรมทั้งหมด</a>
    </div>

    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/list-join-events" style="margin-right: 15px; text-decoration: none; color: #007bff;">กิจกรรมที่คุณเข้าร่วม</a>
            <a href="/events" style="margin-right: 15px; text-decoration: none; color: #007bff;">กิจกรรมของคุณ</a>
            <a href="/personal" style="margin-right: 15px; text-decoration: none; color: #007bff;">ข้อมูลส่วนตัว</a>
            <a href="/logout" style="text-decoration: none; color: red;" onclick="return confirm('ต้องการออกจากระบบใช่หรือไม่?');">ออกจากระบบ</a>

        <?php else: ?>
            <a href="/login" style="margin-right: 15px; text-decoration: none; color: #28a745; font-weight: bold;">เข้าสู่ระบบ</a>
            <a href="/signup" style="text-decoration: none; color: #007bff;">สมัครสมาชิก</a>
        <?php endif; ?>
    </div>
</nav>