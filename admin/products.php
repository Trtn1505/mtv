<?php
// admin/products.php
// Quản lý sản phẩm - JSON version

session_start();
require_once '../config/db.php';
require_once '../config/image-processor.php';

check_admin_login();

$page_title = 'Quản lý sản phẩm';
$admin_layout = 'panel';
$admin_nav_active = 'products';
$admin_section_title = 'Quản lý sản phẩm';
$admin_section_description = 'Thêm, sửa, xóa và tối ưu danh mục sản phẩm năng lượng mặt trời.';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$error = '';
$success = '';
$products = get_table_data('products');

// Sắp xếp theo created_at DESC
usort($products, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Xóa sản phẩm
if($action == 'delete' && $id) {
    $product = get_record('products', $id);
    if($product && !empty($product['image'])) {
        @unlink("../uploads/" . $product['image']);
    }
    delete_record('products', $id);
    header("Location: products.php?success=1");
    exit;
}

// Thêm/Sửa sản phẩm
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape_input($_POST['name'] ?? '');
    $description = escape_input($_POST['description'] ?? '');
    $power = escape_input($_POST['power'] ?? '');
    $price = escape_input($_POST['price'] ?? '');

    if(empty($name) || empty($description)) {
        $error = 'Vui lòng điền tên và mô tả!';
    } else {
        $image = '';
        if(!empty($_FILES['image']['name'])) {
            $result = ImageProcessor::process($_FILES['image'], 'product', '../uploads/');
            if($result['success']) {
                $image = $result['filename'];
            } else {
                $error = $result['error'];
            }
        }

        if($action == 'edit' && $id) {
            $old_product = get_record('products', $id);
            if(empty($image)) {
                $image = $old_product['image'];
            } else if(!empty($old_product['image'])) {
                @unlink("../uploads/" . $old_product['image']);
            }

            if(!$error) {
                update_record('products', $id, [
                    'name' => $name,
                    'description' => $description,
                    'power' => $power,
                    'price' => $price,
                    'image' => $image
                ]);
                $success = 'Cập nhật sản phẩm thành công!';
            }
        } else {
            if(!$error) {
                add_record('products', [
                    'name' => $name,
                    'description' => $description,
                    'power' => $power,
                    'price' => $price,
                    'image' => $image
                ]);
                $success = 'Thêm sản phẩm thành công!';
            }
        }

        if($success) {
            $_POST = [];
            $action = 'list';
            $id = null;
            $products = get_table_data('products');
        }
    }
}

// Lấy dữ liệu để edit
$product = null;
if($action == 'edit' && $id) {
    $product = get_record('products', $id);
    if(!$product) {
        header("Location: products.php");
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
                <div class="card admin-panel-card" style="max-width: 680px;">
                    <div class="card-content">
                        <h3><?php echo $action == 'add' ? 'Thêm sản phẩm mới' : 'Sửa sản phẩm'; ?></h3>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên sản phẩm *</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Mô tả *</label>
                                <textarea name="description" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Công suất</label>
                                    <input type="text" name="power" value="<?php echo htmlspecialchars($product['power'] ?? ''); ?>" placeholder="VD: 400W">
                                </div>
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="text" name="price" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" placeholder="VD: 8.500.000 VNĐ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input type="file" name="image" accept="image/*">
                                <?php if($action == 'edit' && !empty($product['image'])): ?>
                                    <p style="margin-top: 0.5rem; color: #64748b; font-size: 0.9rem;">
                                        <i class="fas fa-check"></i> Ảnh hiện tại: <?php echo htmlspecialchars($product['image']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div style="display: flex; gap: 1rem;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="products.php" class="btn" style="flex: 1; background: #95a5a6; color: white; text-align: center;">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div style="margin-bottom: 2rem;">
                    <a href="?action=add" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
                </div>

                <div class="card admin-panel-card">
                    <div class="card-content">
                        <?php if(count($products) > 0): ?>
                            <div style="overflow-x: auto;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Hình ảnh</th>
                                            <th>Tên</th>
                                            <th>Công suất</th>
                                            <th>Giá</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($products as $row): ?>
                                            <tr>
                                                <td>
                                                    <?php if(!empty($row['image']) && file_exists("../uploads/" . $row['image'])): ?>
                                                        <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-width: 80px; border-radius: 8px;">
                                                    <?php else: ?>
                                                        <div style="width: 80px; height: 60px; background: #ecf0f1; display: flex; align-items: center; justify-content: center; color: #999; border-radius: 8px;">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['power']); ?></td>
                                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                                <td class="actions">
                                                    <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn" style="background: #3498db; color: white;"><i class="fas fa-edit"></i> Sửa</a>
                                                    <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger delete" onclick="return confirm('Bạn chắc chắn muốn xóa?');"><i class="fas fa-trash"></i> Xóa</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p style="text-align: center; color: #64748b; padding: 2rem;">Chưa có sản phẩm nào</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
<?php include '../includes/admin-footer.php'; ?>
