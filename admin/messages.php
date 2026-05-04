<?php
// admin/messages.php
// Quản lý tin nhắn trực tiếp từ contact widget

session_start();
require_once '../config/db.php';

check_admin_login();

$admin_layout = 'panel';
$admin_nav_active = 'messages';
$admin_section_title = 'Liên hệ từ widget';
$admin_section_description = 'Danh sách liên hệ nhanh từ website công khai.';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$messages = [];

// Load messages from JSON
$messages_file = '../data/messages.json';
if(file_exists($messages_file)) {
    $messages = json_decode(file_get_contents($messages_file), true) ?? [];
}

// Sắp xếp từ mới nhất đến cũ nhất
usort($messages, function($a, $b) {
    return strtotime($b['created_at'] ?? 0) - strtotime($a['created_at'] ?? 0);
});

// Xóa tin nhắn
if($action == 'delete' && $id) {
    $messages = array_filter($messages, function($msg) use ($id) {
        return ($msg['id'] ?? '') !== $id;
    });
    file_put_contents($messages_file, json_encode($messages, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    header("Location: messages.php?success=1");
    exit;
}

?>
<?php include '../includes/admin-header.php'; ?>
        <?php if(isset($_GET['success'])): ?>
            <div style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 0.75rem; border-radius: 6px; margin-bottom: 1.5rem;">
                <i class="fas fa-check-circle"></i> Tin nhắn đã xóa
            </div>
        <?php endif; ?>

        <?php if(!empty($messages)): ?>
            <div class="card">
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 18%;">Tên</th>
                                <th style="width: 15%;">Điện thoại</th>
                                <th style="width: 20%;">Email</th>
                                <th>Nội dung</th>
                                <th style="width: 90px;">Ngày</th>
                                <th style="width: 50px;">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($messages as $msg): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars(substr($msg['name'] ?? '', 0, 20)); ?></strong></td>
                                    <td style="font-size: 0.9rem;">
                                        <a href="tel:<?php echo htmlspecialchars($msg['phone'] ?? ''); ?>" style="color: #10b981; text-decoration: none;">
                                            <?php echo htmlspecialchars($msg['phone'] ?? ''); ?>
                                        </a>
                                    </td>
                                    <td style="font-size: 0.9rem;">
                                        <?php if(!empty($msg['email'])): ?>
                                            <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" style="color: #10b981; text-decoration: none;">
                                                <?php echo htmlspecialchars(substr($msg['email'], 0, 20)); ?>
                                            </a>
                                        <?php else: ?>
                                            <span style="color: #cbd5e1;">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-size: 0.9rem; color: #64748b;">
                                        <?php echo htmlspecialchars(substr($msg['message'] ?? '', 0, 60)); ?><?php echo strlen($msg['message'] ?? '') > 60 ? '...' : ''; ?>
                                    </td>
                                    <td style="font-size: 0.85rem; color: #64748b;">
                                        <?php echo date('d/m/Y', strtotime($msg['created_at'] ?? date('Y-m-d'))); ?>
                                    </td>
                                    <td>
                                        <a href="messages.php?action=delete&id=<?php echo htmlspecialchars($msg['id'] ?? ''); ?>" class="btn btn-small btn-danger" onclick="return confirm('Xóa?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-top: 1rem; padding: 1rem; background: #f8fafc; border-radius: 8px; text-align: center; color: #64748b; font-size: 0.9rem;">
                <i class="fas fa-info-circle"></i> Tổng: <strong><?php echo count($messages); ?></strong> tin nhắn
            </div>
        <?php else: ?>
            <div class="card">
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <i class="fas fa-comment-slash" style="font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 1rem;"></i>
                    <p style="font-size: 1rem; margin: 0;">Chưa có tin nhắn nào</p>
                    <p style="font-size: 0.9rem; margin: 0.5rem 0 0;">Tin nhắn sẽ hiển thị ở đây khi khách hàng gửi từ widget</p>
                </div>
            </div>
        <?php endif; ?>
<?php include '../includes/admin-footer.php'; ?>
