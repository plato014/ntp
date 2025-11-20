<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ฟอร์มสมัครสมาชิก</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 420px; margin: 0 auto; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type="text"],
        input[type="email"],
        input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; margin-top: 4px; }
        .actions { margin-top: 16px; }
        .actions button { padding: 8px 14px; }
    </style>
</head>
<body>
    <h1>สมัครสมาชิก</h1>

    <form method="POST" action="register_save.php" novalidate>
        <label for="username">Username (ชื่อผู้ใช้)</label>
        <input type="text" id="username" name="username" placeholder="username" required>

        <label for="email">Email (อีเมล)</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required>

        <label for="full_name">Full name (ชื่อ-นามสกุล)</label>
        <input type="text" id="full_name" name="full_name" placeholder="ชื่อ-นามสกุล" required>

        <label for="password">Password (รหัสผ่าน)</label>
        <input type="password" id="password" name="password" placeholder="รหัสผ่าน" required>

        <label for="confirm_password">Confirm Password (ยืนยันรหัสผ่าน)</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" required>

        <div class="actions">
            <button type="submit">ลงทะเบียน</button>
            <button type="reset">ยกเลิก</button>
        </div>
    </form>
</body>
</html>