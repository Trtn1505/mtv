<?php
// admin/projects.php
// Quản lý dự án - JSON version

session_start();
require_once '../config/db.php';
require_once '../config/image-processor.php';

check_admin_login();

$admin_layout = 'panel';
$admin_nav_active = 'projects';
$admin_section_title = 'Quản lý dự án';
$admin_section_description = 'Theo dõi các hệ thống điện mặt trời đã triển khai và cập nhật tiến độ.';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$error = '';
$success = '';
$projects = get_table_data('projects');

// Sắp xếp theo created_at DESC
usort($projects, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Xóa dự án
if($action == 'delete' && $id) {
    $project = get_record('projects', $id);
    if($project && !empty($project['image'])) {
        @unlink("../uploads/" . $project['image']);
    }
    delete_record('projects', $id);
    header("Location: projects.php?success=1");
    exit;
}

// Thêm/Sửa dự án
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape_input($_POST['name'] ?? '');
    $location = escape_input($_POST['location'] ?? '');
    $capacity = escape_input($_POST['capacity'] ?? '');
    $description = escape_input($_POST['description'] ?? '');

    if(empty($name) || empty($location)) {
        $error = 'Vui lòng điền tên và địa điểm!';
    } else {
        // Upload ảnh
        $image = '';
        if(!empty($_FILES['image']['name'])) {
            $result = ImageProcessor::process($_FILES['image'], 'project', '../uploads/');
            if($result['success']) {
                $image = $result['filename'];
            } else {
                $error = $result['error'];
            }
        }

        if($action == 'edit' && $id) {
            $old_project = get_record('projects', $id);
            if(empty($image)) {
                $image = $old_project['image'];
            } else if(!empty($old_project['image'])) {
                @unlink("../uploads/" . $old_project['image']);
            }

            if(!$error) {
                update_record('projects', $id, [
                    'name' => $name,
                    'location' => $location,
                    'capacity' => $capacity,
                    'description' => $description,
                    'image' => $image
                ]);
                $success = 'Cập nhật dự án thành công!';
            }
        } else {
            if(!$error) {
                add_record('projects', [
                    'name' => $name,
                    'location' => $location,
                    'capacity' => $capacity,
                    'description' => $description,
                    'image' => $image
                ]);
                $success = 'Thêm dự án thành công!';
            }
        }

        $_POST = [];
        $action = 'list';
        $id = null;
        $projects = get_table_data('projects');
    }
}

// Lấy dữ liệu để edit
$project = null;
if($action == 'edit' && $id) {
    $project = get_record('projects', $id);
    if(!$project) {
        header("Location: projects.php");
        exit;
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

            <?php if($action == 'add' || $action == 'edit'): ?>
                <div class="card" style="max-width: 700px;">
                    <div class="card-content">
                        <h3><?php echo $action == 'add' ? 'Thêm dự án mới' : 'Sửa dự án'; ?></h3>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên dự án *</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($project['name'] ?? ''); ?>" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Địa điểm *</label>
                                    <input type="text" name="location" value="<?php echo htmlspecialchars($project['location'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Công suất</label>
                                    <input type="text" name="capacity" value="<?php echo htmlspecialchars($project['capacity'] ?? ''); ?>" placeholder="VD: 50KW">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="description"><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input type="file" name="image" accept="image/*">
                                <?php if($action == 'edit' && $project['image']): ?>
                                    <p style="margin-top: 0.5rem; color: #666;">
                                        <i class="fas fa-check"></i> Ảnh hiện tại: <?php echo htmlspecialchars($project['image']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div style="display: flex; gap: 1rem;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="projects.php" class="btn" style="flex: 1; background: #95a5a6; color: white; text-align: center;">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div style="margin-bottom: 2rem;">
                    <a href="?action=add" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm dự án
                    </a>
                </div>

                <div class="card">
                    <div class="card-content">
                        <?php
                        if(count($projects) > 0) {
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Địa điểm</th>
                                        <th>Công suất</th>
                                        <th>Hình ảnh</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($projects as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                                            <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                                            <td>
                                                <?php if(!empty($row['image']) && file_exists("../uploads/" . $row['image'])): ?>
                                                    <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-width: 80px; border-radius: 4px;">
                                                <?php else: ?>
                                                    <div style="width: 80px; height: 60px; background: #ecf0f1; display: flex; align-items: center; justify-content: center; color: #999;">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="actions">
                                                <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn" style="background: #3498db; color: white;">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger delete" onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo '<p style="text-align: center; color: #999; padding: 2rem;">Chưa có dự án nào</p>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
<?php include '../includes/admin-footer.php'; ?>
