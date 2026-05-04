<?php
// admin/login.php
// Đăng nhập admin - dùng JSON
session_start();
require_once '../config/db.php';
$error = '';
$admin_layout = 'auth';
$admin_section_title = 'Đăng nhập quản trị';
$admin_section_description = 'Truy cập dashboard, bài viết, dự án, sản phẩm và liên hệ.';
// Kiểm tra nếu đã login rồi
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
// Xử lý form submit
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = escape_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if(empty($username) || empty($password)) {
        $error = 'Vui lòng điền username và password!';
    } else {
        // Lấy dữ liệu admin từ JSON
        $admin_data = get_json_data('admin');
        $admin = $admin_data['admin'] ?? null;
        if($admin && $username === $admin['username'] && password_verify($password, $admin['password'])) {
            // Đúng - tạo session
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Username hoặc password không chính xác!';
        }
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
        <div class="login-container">
            <p class="login-kicker">Solar Energy Admin</p>
            <h2><i class="fas fa-lock"></i> Đăng nhập quản trị</h2>
            <p class="login-intro">Truy cập dashboard, bài viết, dự án, sản phẩm và liên hệ.</p>
            <?php if($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">
                    Đăng nhập
                </button>
                <p style="text-align: center; color: #64748b;">
                    <a href="/" style="color: #059669; text-decoration: none;">← Quay lại trang chủ</a>
                </p>
            </form>
            <div class="login-note">
                <p><strong>Tài khoản test:</strong></p>
                <p>Username: admin</p>
                <p>Password: admin123</p>
            </div>
        </div>
<?php include '../includes/admin-footer.php'; ?>