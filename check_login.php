<?php
session_start();

include ('connect.php'); // ต้องแน่ใจว่าไฟล์นี้กำหนดตัวแปร $conn อย่างถูกต้อง

// ป้องกัน Notice เมื่อฟอร์มไม่ถูกส่ง
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// ตรวจสอบ connection ว่ามีหรือไม่
if (!isset($conn) || !$conn) {
    die('Database connection not found.');
}

// ตรวจสอบค่าที่ผู้ใช้กรอกก่อนทำ SQL
if ($username === '' || $password === '') {
    echo "<script>alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน'); window.history.back();</script>";
    exit();
}

// --- ใช้ Prepared Statement และเลือกคอลัมน์ที่ต้องการ ---
$sql = "SELECT id, fullname, username, password, position FROM member WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    die('SQL Prepare failed: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

// ดึงผลลัพธ์ (รองรับกรณีไม่มี mysqli_stmt_get_result)
$row = null;
if (function_exists('mysqli_stmt_get_result')) {
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }
} else {
    // fallback หาก PHP ไม่ได้ติดตั้ง mysqlnd
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // ตามลำดับคอลัมน์ใน SELECT: id, fullname, username, password
        mysqli_stmt_bind_result($stmt, $id, $fullname, $username_db, $password_hash, $position_val);
        if (mysqli_stmt_fetch($stmt)) {
            $row = [
                'id' => $id,
                'fullname' => $fullname,
                'username' => $username_db,
                'password' => $password_hash,
                'position' => $position_val // เก็บค่าลง array
            ];
        }
    }
}

// ตรวจสอบผลการค้นหาและรหัสผ่าน
if ($row) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['username'] = $row['username'];
        $uid = $row['id'];
        $update_time = "UPDATE member SET last_login = NOW() WHERE id = '$uid'";
        mysqli_query($conn, $update_time); 
        // ----------------------------------------------------

        // ตรวจสอบ Position และ Redirect
        if ($row['position'] == 'admin') {
            $_SESSION['position'] = 'admin';
            echo "<script>
                    alert('ยินดีต้อนรับผู้ดูแลระบบ');
                    window.location.href = 'admin_page.php';
                  </script>";
        } elseif ($row['position'] == 'user') {
            $_SESSION['position'] = 'user';
            echo "<script>
                    alert('ยินดีต้อนรับสมาชิก');
                    window.location.href = 'profile.php';
                  </script>";
        } else {
            $_SESSION['position'] = 'guest';
            echo "<script>
                    alert('ยินดีต้อนรับผู้เยี่ยมชม');
                    window.location.href = 'profile.php';
                  </script>";
        }
        exit(); // จบการทำงานทันทีหลังจากสั่ง Redirect

    } else {
        echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ไม่พบชื่อผู้ใช้นี้ในระบบ'); window.history.back();</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>