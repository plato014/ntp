<?php
session_start();

// ทำลาย Session ทั้งหมด
session_unset();
session_destroy();

// ส่งผู้ใช้กลับไปหน้าล็อกอิน
header('Location: login.php'); // สมมติว่าหน้าฟอร์มล็อกอินคือ login.php
exit();
?>