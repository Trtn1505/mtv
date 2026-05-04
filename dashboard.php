<?php
// admin/dashboard.php
// Dashboard admin - JSON version

session_start();
require_once '../config/db.php';

check_admin_login();

$page_title = 'Dashboard Admin';

// Lấy số lượng dữ liệu
$products_count = count(get_table_data('products'));
$posts_count = count(get_table_data('posts'));
$projects_count = count(get_table_data('projects'));
$contacts_count = count(get_table_data('contacts'));
$contacts = get_table_data('contacts');

// Lấy tin nhắn trực tiếp
$messages_file = '../data/messages.json';
$messages = [];
$messages_count = 0;
if(file_exists($messages_file)) {
    $messages = json_decode(file_get_contents($messages_file), true) ?? [];
    $messages_count = count($messages);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Năng Lượng Mặt Trời</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="/" class="logo">
                    <i class="fas fa-sun"></i> Solar Energy Admin
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="products.php">Sản phẩm</a></li>
                <li><a href="posts.php">Tin tức</a></li>
                <li><a href="projects.php">Dự án</a></li>
                <li><a href="messages.php"><i class="fas fa-comment-dots"></i> Tin nhắn (<?php echo $messages_count; ?>)</a></li>
                <li><a href="logout.php" style="background: #e74c3c; padding: 0.5rem 1rem; border-radius: 4px;">Đăng xuất</a></li>
            </ul>
        </div>
    </nav>

    <div class="admin-header">
        <div class="container">
            <h1>Dashboard</h1>
            <p class="user-info">Xin chào, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></p>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <!-- Thống kê -->
            <div class="admin-dashboard">
                <div class="stat-card">
                    <div class="label">Tổng sản phẩm</div>
                    <div class="value"><?php echo $products_count; ?></div>
                    <a href="products.php" style="color: #27ae60; text-decoration: none; margin-top: 0.5rem; display: block;">
                        Quản lý →
                    </a>
                </div>

                <div class="stat-card">
                    <div class="label">Tổng bài viết</div>
                    <div class="value"><?php echo $posts_count; ?></div>
                    <a href="posts.php" style="color: #27ae60; text-decoration: none; margin-top: 0.5rem; display: block;">
                        Quản lý →
                    </a>
                </div>

                <div class="stat-card">
                    <div class="label">Tổng dự án</div>
                    <div class="value"><?php echo $projects_count; ?></div>
                    <a href="projects.php" style="color: #27ae60; text-decoration: none; margin-top: 0.5rem; display: block;">
                        Quản lý →
                    </a>
                </div>

                <div class="stat-card">
                    <div class="label">Liên hệ mới</div>
                    <div class="value"><?php echo $contacts_count; ?></div>
                </div>

                <div class="stat-card">
                    <div class="label">Tin nhắn trực tiếp</div>
                    <div class="value"><?php echo $messages_count; ?></div>
                    <a href="messages.php" style="color: #27ae60; text-decoration: none; margin-top: 0.5rem; display: block;">
                        Quản lý →
                    </a>
                </div>
            </div>

            <!-- Liên hệ mới nhất -->
            <div class="card" style="margin-top: 3rem;">
                <div class="card-content">
                    <h3><i class="fas fa-envelope"></i> Liên hệ mới nhất</h3>
                    
                    <?php
                    if(count($contacts) > 0) {
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $recent = array_slice($contacts, -5);
                                foreach(array_reverse($recent) as $contact) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['email'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($contact['phone'] ?? '-'); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($contact['created_at'])); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo '<p style="color: #999; text-align: center;">Chưa có liên hệ nào</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- Thông tin công ty -->
            <div class="card" style="margin-top: 3rem;">
                <div class="card-content">
                    <h3><i class="fas fa-building"></i> Thông tin công ty</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 1.5rem;">
                        <div>
                            <p style="color: #64748b; margin-bottom: 0.5rem; font-size: 0.9rem;"><i class="fas fa-briefcase"></i> <strong>Tên công ty</strong></p>
                            <p style="color: #1e293b; font-size: 1.1rem; font-weight: 600;">Công Ty TNHH ENERGY Mặt Trời Việt</p>
                        </div>
                        <div>
                            <p style="color: #64748b; margin-bottom: 0.5rem; font-size: 0.9rem;"><i class="fas fa-phone"></i> <strong>Điện thoại</strong></p>
                            <p style="color: #1e293b;"><a href="tel:0789686565" style="color: #10b981; text-decoration: none; font-weight: 600;">0789686565</a></p>
                        </div>
                        <div>
                            <p style="color: #64748b; margin-bottom: 0.5rem; font-size: 0.9rem;"><i class="fas fa-envelope"></i> <strong>Email</strong></p>
                            <p style="color: #1e293b;"><a href="mailto:info@solar.vn" style="color: #10b981; text-decoration: none;">info@solar.vn</a></p>
                        </div>
                        <div>
                            <p style="color: #64748b; margin-bottom: 0.5rem; font-size: 0.9rem;"><i class="fas fa-map"></i> <strong>Bản đồ</strong></p>
                            <p style="color: #1e293b;"><a href="https://maps.app.goo.gl/V8geD9qtEMJe6M1P8" target="_blank" style="color: #10b981; text-decoration: none;">Xem bản đồ</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
