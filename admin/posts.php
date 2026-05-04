<?php
// admin/posts.php
// Quản lý bài viết tin tức - JSON version

session_start();
require_once '../config/db.php';
require_once '../config/image-processor.php';

check_admin_login();

$admin_layout = 'panel';
$admin_nav_active = 'posts';
$admin_section_title = 'Quản lý tin tức';
$admin_section_description = 'Cập nhật bài viết, nội dung tư vấn và kiến thức cho khách hàng.';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$error = '';
$success = '';
$posts = get_table_data('posts');

// Sắp xếp theo created_at DESC
usort($posts, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Xóa bài viết
if($action == 'delete' && $id) {
    $post = get_record('posts', $id);
    if($post && !empty($post['image'])) {
        @unlink("../uploads/" . $post['image']);
    }
    delete_record('posts', $id);
    header("Location: posts.php?success=1");
    exit;
}

// Thêm/Sửa bài viết
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = escape_input($_POST['title'] ?? '');
    $content = escape_input($_POST['content'] ?? '');

    if(empty($title) || empty($content)) {
        $error = 'Vui lòng điền tiêu đề và nội dung!';
    } else {
        $image = '';
        if(!empty($_FILES['image']['name'])) {
            $result = ImageProcessor::process($_FILES['image'], 'post', '../uploads/');
            if($result['success']) {
                $image = $result['filename'];
            } else {
                $error = $result['error'];
            }
        }

        if($action == 'edit' && $id) {
            $old_post = get_record('posts', $id);
            if(empty($image)) {
                $image = $old_post['image'];
            } else if(!empty($old_post['image'])) {
                @unlink("../uploads/" . $old_post['image']);
            }

            if(!$error) {
                update_record('posts', $id, [
                    'title' => $title,
                    'content' => $content,
                    'image' => $image
                ]);
                $success = 'Cập nhật bài viết thành công!';
            }
        } else {
            if(!$error) {
                add_record('posts', [
                    'title' => $title,
                    'content' => $content,
                    'image' => $image
                ]);
                $success = 'Thêm bài viết thành công!';
            }
        }

        if($success) {
            $_POST = [];
            $action = 'list';
            $id = null;
            $posts = get_table_data('posts');
        }
    }
}
?>
<?php include '../includes/admin-header.php'; ?>
            <?php if($success): ?>
                <div class="alert alert-success"><i class="fas fa-check"></i> <?php echo $success; ?></div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="alert alert-danger"><i class="fas fa-times"></i> <?php echo $error; ?></div>
            <?php endif; ?>

<?php if($error): ?>
    <div class="alert alert-danger"><i class="fas fa-times"></i> <?php echo $error; ?></div>
<?php endif; ?>

<?php if($action == 'add' || $action == 'edit'): ?>
    <div class="card admin-panel-card" style="max-width: 680px;">
        <div class="card-content">
            <h3><?php echo $action == 'add' ? 'Thêm bài viết mới' : 'Sửa bài viết'; ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tiêu đề *</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Nội dung *</label>
                    <textarea name="content" required><?php echo htmlspecialchars($post['content'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" name="image" accept="image/*">
                    <?php if($action == 'edit' && !empty($post['image'])): ?>
                        <p style="margin-top: 0.5rem; color: #64748b; font-size: 0.9rem;">
                            <i class="fas fa-check"></i> Ảnh hiện: <?php echo htmlspecialchars($post['image']); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">Lưu</button>
                    <a href="posts.php" class="btn" style="flex: 1; justify-content: center; background: #95a5a6; color: white;">Hủy</a>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <div style="margin-bottom: 1.5rem;">
        <a href="?action=add" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm bài viết</a>
    </div>

    <div class="card admin-panel-card">
        <div class="card-content">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Hình</th>
                            <th>Tiêu đề</th>
                            <th style="width: 120px;">Ngày tạo</th>
                            <th style="width: 90px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($posts)): ?>
                            <?php foreach($posts as $row): ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($row['image']) && file_exists("../uploads/" . $row['image'])): ?>
                                            <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; background: #ecf0f1; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars(substr($row['title'], 0, 40)); ?></strong></td>
                                    <td style="font-size: 0.9rem;"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                    <td class="action-btns">
                                        <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-small" style="background: #3498db; color: white;"><i class="fas fa-edit"></i></a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Xóa?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b; padding: 2rem;">Chưa có bài viết nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if($action == 'add' || $action == 'edit'): ?>
            <div class="card" style="max-width: 600px;">
                <div class="card-content">
                    <h2 style="margin: 0 0 1.5rem; font-size: 1.2rem;">
                        <?php echo $action == 'add' ? '+ Thêm bài viết' : '✎ Sửa bài viết'; ?>
                    </h2>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Tiêu đề *</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Nội dung *</label>
                            <textarea name="content" required><?php echo htmlspecialchars($post['content'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="image" accept="image/*">
                            <?php if($action == 'edit' && !empty($post['image'])): ?>
                                <p style="margin-top: 0.5rem; color: #10b981; font-size: 0.85rem;">
                                    <i class="fas fa-check"></i> Ảnh hiện: <?php echo htmlspecialchars($post['image']); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; gap: 0.75rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">Lưu</button>
                            <a href="posts.php" class="btn" style="flex: 1; justify-content: center; background: #95a5a6; color: white;">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div style="margin-bottom: 1.5rem;">
                <a href="?action=add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm bài viết
                </a>
            <div class="card">
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Hình</th>
                                <th>Tiêu đề</th>
                                <th style="width: 120px;">Ngày tạo</th>
                                <th style="width: 90px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($posts)): ?>
                                <?php foreach($posts as $row): ?>
                                    <tr>
                                        <td>
                                            <?php if(!empty($row['image']) && file_exists("../uploads/" . $row['image'])): ?>
                                                <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="">
                                            <?php else: ?>
                                                <div style="width: 50px; height: 35px; background: #ecf0f1; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #999;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong><?php echo htmlspecialchars(substr($row['title'], 0, 40)); ?></strong></td>
                                        <td style="font-size: 0.9rem;"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                        <td class="action-btns">
                                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-small" style="background: #3498db; color: white;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Xóa?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; color: #999; padding: 2rem;">
                                        Chưa có bài viết nào
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
<?php include '../includes/admin-footer.php'; ?>
