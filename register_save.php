<?php
    include 'connect.php';

    // รับค่าจากฟอร์ม
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $confirm_password = $_POST['confirm_password'] ?? '';

    // ตรวจสอบข้อมูล
    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "รหัสผ่านไม่ตรงกัน";
        exit;
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "อีเมลไม่ถูกต้อง";
        exit;
    }

    // สร้างรหัสผ่านที่ปลอดภัยด้วย password_hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // บันทึกลงฐานข้อมูล (ใช้ prepared statement)
    $sql = "INSERT INTO member (username, password, fullname, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
        exit;
    }

    $stmt->bind_param("ssss", $username, $hashed_password, $full_name, $email);

    if ($stmt->execute()) {
        // *** ส่วนที่ถูกแก้ไข ***
        // 1. แสดงข้อความแจ้งเตือน (Optional: หากไม่ต้องการแจ้งเตือน ก็ลบโค้ดนี้)
        echo "<script>alert('ลงทะเบียนเรียบร้อยแล้ว');</script>";
        
        // 2. เปลี่ยนเส้นทางไปยังหน้า login.php
        header('Location: login.php');
        exit(); // สำคัญ: ต้องใช้ exit() หลัง header()
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึก: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();