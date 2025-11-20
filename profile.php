<?php
/*
session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าส่วนตัว (Profile)</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php
// --- ตรวจสอบสิทธิ์การเข้าถึง ---
if (!isset($_SESSION['id'])) {
    echo "<h1>❌ เข้าถึงหน้านี้ไม่ได้</h1>";
    echo "<p>กรุณาล็อกอินก่อนครับ</p>";
    echo "<a href='login.php'>ไปหน้าล็อกอิน</a>"; 
    exit(); 
}
// ถ้าล็อกอินแล้ว ข้อมูล Session จะพร้อมใช้งาน
$fullname = htmlspecialchars($_SESSION['fullname']); // ดึง fullname มาเตรียมไว้
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ระบบสมาชิก</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">หน้าหลัก</a>
        </li>
        </ul>

      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link text-warning">
            สวัสดีคุณ, <strong><?php echo $fullname; ?></strong>
          </span>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-danger ms-2" href='logout.php'>ออกจากระบบ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="alert alert-success" role="alert">
        เข้าสู่ระบบสำเร็จแล้ว
    </div>
    
    <h1>ข้อมูลส่วนตัว</h1>
    <p>username ของคุณ: **<?php echo htmlspecialchars($_SESSION['username']); ?>**</p>
    <p>รหัสสมาชิก: **<?php echo htmlspecialchars($_SESSION['id']); ?>**</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
*/
session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าส่วนตัว (Profile)</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa; /* สีพื้นหลังเทาอ่อน สบายตา */
        }
        .card-profile {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* เงาฟุ้งๆ */
        }
        .avatar-img {
            border: 4px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<?php
// --- ตรวจสอบสิทธิ์การเข้าถึง ---
if (!isset($_SESSION['id'])) {
?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center shadow-sm p-4" style="max-width: 400px; width: 100%; border-radius: 15px;">
            <div class="card-body">
                <div class="text-danger mb-3">
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 4rem;"></i>
                </div>
                <h2 class="card-title fw-bold text-danger">เข้าถึงไม่ได้</h2>
                <p class="card-text text-muted">กรุณาล็อกอินเข้าสู่ระบบก่อนใช้งานหน้านี้ครับ</p>
                <a href="login.php" class="btn btn-primary w-100 rounded-pill mt-3">
                    <i class="bi bi-box-arrow-in-right"></i> ไปหน้าล็อกอิน
                </a>
            </div>
        </div>
    </div>
<?php
    exit(); // จบการทำงานทันทีถ้าไม่ได้ล็อกอิน
}

// ถ้าล็อกอินแล้ว ดึงข้อมูลมาใช้
$fullname = htmlspecialchars($_SESSION['fullname']);
$username = htmlspecialchars($_SESSION['username']);
$user_id  = htmlspecialchars($_SESSION['id']);

// สร้าง URL รูป avatar จากชื่อ (ลูกเล่นเสริม)
$avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($fullname) . "&background=0D6EFD&color=fff&size=128";
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
        <i class="bi bi-shield-lock-fill text-primary"></i> ระบบสมาชิก
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-house-door"></i> หน้าหลัก</a>
        </li>
      </ul>

      <ul class="navbar-nav align-items-center">
        <li class="nav-item me-3 text-light d-none d-lg-block">
            <small class="text-muted">ยินดีต้อนรับ,</small> <span class="fw-bold text-warning"><?php echo $fullname; ?></span>
        </li>
        <li class="nav-item">
          <a class="btn btn-sm btn-outline-danger rounded-pill px-3" href='logout.php'>
            <i class="bi bi-power"></i> ออกจากระบบ
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> เข้าสู่ระบบสำเร็จแล้ว
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="card card-profile mt-4">
                <div class="card-header bg-primary text-white text-center py-4" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0"><i class="bi bi-person-vcard"></i> ข้อมูลส่วนตัว</h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="text-center mb-4 mt-n5">
                        <img src="<?php echo $avatar_url; ?>" alt="Profile" class="rounded-circle avatar-img" width="100">
                        <h3 class="mt-3 mb-0 fw-bold"><?php echo $fullname; ?></h3>
                        <p class="text-muted">User Level: Member</p>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-person text-primary me-2"></i> Username</span>
                            <span class="fw-bold text-dark"><?php echo $username; ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-upc-scan text-primary me-2"></i> รหัสสมาชิก (ID)</span>
                            <span class="badge bg-secondary rounded-pill fs-6"><?php echo $user_id; ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span><i class="bi bi-calendar-check text-primary me-2"></i> สถานะ</span>
                            <span class="text-success"><i class="bi bi-dot"></i> ออนไลน์</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-outline-primary rounded-pill">
                            <i class="bi bi-pencil-square"></i> แก้ไขข้อมูล
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
