<?php
// admin/dashboard.php
// Dashboard admin - JSON version

session_start();
require_once '../config/db.php';

check_admin_login();

$page_title = 'Dashboard Admin';
$admin_layout = 'panel';
$admin_nav_active = 'dashboard';
$admin_section_title = 'Dashboard';
$admin_section_description = 'Theo dõi nhanh toàn bộ nội dung, liên hệ và tin nhắn từ một nơi.';

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
<?php include '../includes/admin-header.php'; ?>
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
<?php include '../includes/admin-footer.php'; ?>
