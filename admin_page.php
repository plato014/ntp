<?php
session_start();
include('connect.php'); // 1. เชื่อมต่อฐานข้อมูล

// --- ตรวจสอบสิทธิ์ Admin ---
// ถ้าไม่ได้ล็อกอิน หรือ ไม่ใช่ admin ให้ดีดออก
if (!isset($_SESSION['id']) || $_SESSION['position'] != 'admin') {
    echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้'); window.location.href='login.php';</script>";
    exit();
}

$admin_name = htmlspecialchars($_SESSION['fullname']);

// --- 2. ดึงข้อมูลมาแสดงผล ---

// 2.1 นับจำนวนสมาชิกทั้งหมด
$sql_total = "SELECT COUNT(*) as total FROM member";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_members = $row_total['total'];

// นับจำนวนคนออนไลน์ (เข้าใช้งานภายใน 10 นาทีที่ผ่านมา)
$time_check = date("Y-m-d H:i:s", strtotime("-10 minutes")); // ย้อนหลัง 10 นาที
$sql_online = "SELECT COUNT(*) as online FROM member WHERE last_login > '$time_check'";
$result_online = mysqli_query($conn, $sql_online);
$row_online = mysqli_fetch_assoc($result_online);
$online_members = $row_online['online'];

// 2.2 ดึงรายชื่อสมาชิกทั้งหมด (เรียงตาม ID)
$sql = "SELECT * FROM member ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

// คำนวณคนออฟไลน์
$offline_members = $total_members - $online_members;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - จัดการข้อมูลจริง</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background-color: #f8f9fa; }
        .card-custom {
            border: none; border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .card-custom:hover { transform: translateY(-5px); }
        .avatar-mini {
            width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;
        }
        .stat-icon {
            width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold text-uppercase" href="#">
        <i class="bi bi-speedometer2 text-danger"></i> Admin Panel
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="#">ภาพรวม</a></li>
      </ul>
      <div class="d-flex align-items-center text-light">
        <div class="me-3 text-end">
            <div class="fw-bold"><?php echo $admin_name; ?></div>
            <small class="text-muted">Administrator</small>
        </div>
        <a class="btn btn-sm btn-danger rounded-pill px-3" href='logout.php'>Logout</a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid px-4 mt-4">
    
    <h3 class="mb-4"><i class="bi bi-database-fill text-primary me-2"></i> ข้อมูลสมาชิกในระบบ</h3>

    <div class="row g-3 mb-4">
        
        <div class="col-md-4">
            <div class="card card-custom p-3 h-100 border-start border-5 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">สมาชิกทั้งหมด</p>
                        <h2 class="fw-bold mb-0"><?php echo number_format($total_members); ?></h2>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card card-custom h-100 border-0 shadow-sm">
                <div class="card-body p-0 d-flex h-100">
                    
                    <div class="w-50 p-3 d-flex align-items-center justify-content-between border-end" style="background-color: #e8f5e9; border-radius: 15px 0 0 15px;">
                        <div>
                            <p class="text-success mb-1 fw-bold"><i class="bi bi-circle-fill small me-1"></i> ออนไลน์ขณะนี้</p>
                            <h2 class="fw-bold text-success mb-0"><?php echo $online_members; ?></h2>
                            <small class="text-muted" style="font-size: 0.8rem;">(Active 10 นาทีล่าสุด)</small>
                        </div>
                        <div class="stat-icon bg-success text-white shadow-sm">
                            <i class="bi bi-wifi"></i>
                        </div>
                    </div>

                    <div class="w-50 p-3 d-flex align-items-center justify-content-between" style="background-color: #f8f9fa; border-radius: 0 15px 15px 0;">
                        <div>
                            <p class="text-secondary mb-1 fw-bold"><i class="bi bi-moon-fill small me-1"></i> ออฟไลน์</p>
                            <h2 class="fw-bold text-secondary mb-0"><?php echo $offline_members; ?></h2>
                            <small class="text-muted" style="font-size: 0.8rem;">ไม่ได้ใช้งาน</small>
                        </div>
                        <div class="stat-icon bg-secondary text-white shadow-sm">
                            <i class="bi bi-power"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>

    <div class="card card-custom mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
            <h5 class="mb-0 fw-bold">📂 รายชื่อสมาชิก (จาก Database)</h5>
            <button class="btn btn-success rounded-pill btn-sm"><i class="bi bi-plus-lg"></i> เพิ่มสมาชิก</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>ข้อมูลผู้ใช้</th>
                            <th>Username</th>
                            <th>ระดับ (Role)</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // --- 3. วนลูปแสดงข้อมูลจริง ---
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                
                                // สร้าง URL รูปโปรไฟล์จากชื่อจริง (ใช้ fullname)
                                $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($row['fullname']) . "&background=random";
                                
                                // กำหนดสี Badge ตาม Position
                                $badge_color = 'bg-secondary';
                                $badge_text = $row['position'];
                                
                                if($row['position'] == 'admin') {
                                    $badge_color = 'bg-danger'; // Admin สีแดง
                                    $badge_text = 'Admin';
                                } else if ($row['position'] == 'member') {
                                    $badge_color = 'bg-success'; // Member สีเขียว
                                    $badge_text = 'Member';
                                }
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?php echo $row['id']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $avatar_url; ?>" class="avatar-mini shadow-sm" alt="">
                                    <div>
                                        <div class="fw-bold"><?php echo htmlspecialchars($row['fullname']); ?></div>
                                        <small class="text-muted">Password: ******</small> </div>
                                </div>
                            </td>
                            <td><span class="text-primary"><?php echo htmlspecialchars($row['username']); ?></span></td>
                            <td>
                                <span class="badge <?php echo $badge_color; ?> rounded-pill px-3">
                                    <?php echo $badge_text; ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                                <a href="delete_member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('ยืนยันการลบข้อมูล?');"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php 
                            } // ปิด loop while
                        } else {
                            // กรณีไม่มีข้อมูลในฐานข้อมูล
                            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>ไม่พบข้อมูลสมาชิกในระบบ</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>