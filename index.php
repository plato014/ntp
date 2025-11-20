<?php
session_start();

if (empty($_SESSION['id'])) {
    echo "<script>
            alert('กรุณาเข้าสู่ระบบก่อน');
            window.location.href = 'login.php';
          </script>";
    exit();
} else {
    header("Location: profile.php");
    exit();
}
?>