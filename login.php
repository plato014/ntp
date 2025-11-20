<!doctype html>
<html lang="th">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f0f8ff; /* สีฟ้าอ่อน */
      }
      .login-container {
        max-width: 400px;
        margin-top: 100px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      }
      .btn-primary {
        background-color: #007bff;
        border: none;
      }
      .btn-primary:hover {
        background-color: #0056b3;
      }
      .btn-secondary {
        background-color: #6c757d;
        border: none;
      }
      .btn-secondary:hover {
        background-color: #5a6268;
      }
      .form-label {
        font-weight: 500;
      }
      .login-header {
        text-align: center;
        margin-bottom: 25px;
        color: #007bff;
      }
    </style>
  </head>
  <body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
      <div class="login-container">
        <h2 class="login-header">เข้าสู่ระบบ</h2>
        <form action="check_login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">กรอกผู้ใช้</label>
            <input type="text" class="form-control" id="username" placeholder="กรอกผู้ใช้" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control" id="password" placeholder="กรอกรหัสผ่าน" name="password" required>
          </div>
          
          <button type="submit" class="btn btn-primary w-100 mb-2">เข้าสู่ระบบ</button>
          <a href="register_form.php" class="btn btn-secondary w-100">สมัครสมาชิก</a>
        </form>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
