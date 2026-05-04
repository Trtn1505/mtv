<?php
// contact.php
// Trang liên hệ

session_start();
require_once 'config/db.php';

$page_title = 'Để lại liên hệ';

$success = false;
$error = '';

// Xử lý form submit
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape_input($_POST['name'] ?? '');
    $phone = escape_input($_POST['phone'] ?? '');
    $email = escape_input($_POST['email'] ?? '');
    $message = escape_input($_POST['message'] ?? '');

    // Kiểm tra đầu vào
    if(empty($name) || empty($email) || empty($message)) {
        $error = 'Vui lòng điền đầy đủ các trường bắt buộc!';
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ!';
    } else {
        // Save vào JSON
        if(add_record('contacts', [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'message' => $message
        ])) {
            $success = true;
        } else {
            $error = 'Lỗi khi gửi liên hệ. Vui lòng thử lại!';
        }
    }
}

include 'includes/header.php';
?>

<section class="section contact-page">
    <div class="container">
        <div class="section-header">
            <h2>Để lại liên hệ</h2>
            <p>Chia sẻ nhu cầu của bạn, chúng tôi sẽ gọi lại và tư vấn giải pháp phù hợp nhất.</p>
        </div>

        <div class="contact-layout">
            <!-- Form -->
            <div class="contact-form-column">
                <?php if($success): ?>
                    <div class="alert alert-success" style="margin-bottom: 2rem;">
                        <i class="fas fa-check-circle"></i> Cảm ơn! Chúng tôi sẽ liên lạc lại với bạn sớm.
                    </div>
                <?php endif; ?>

                <?php if($error): ?>
                    <div class="alert alert-danger" style="margin-bottom: 2rem;">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="card contact-card">
                    <div class="card-content">
                        <h3><i class="fas fa-phone-volume"></i> Gọi tư vấn hoặc để lại liên hệ</h3>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Tên của bạn *</label>
                                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại *</label>
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="message">Nội dung cần hỗ trợ *</label>
                                <textarea id="message" name="message" style="min-height: 140px;" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-paper-plane"></i> Gửi liên hệ
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="contact-info-column">
                <div class="card contact-info-card">
                    <div class="card-content">
                        <h3><i class="fas fa-building"></i> Thông tin công ty</h3>
                        
                        <div class="contact-info-stack">
                            <div class="contact-info-item contact-info-item-primary">
                                <p><i class="fas fa-phone"></i> Điện thoại</p>
                                <a href="tel:0789686565">0789686565</a>
                            </div>

                            <div class="contact-info-item">
                                <p><i class="fas fa-envelope"></i> Email</p>
                                <a href="mailto:info@solar.vn">info@solar.vn</a>
                            </div>

                            <div class="contact-info-item">
                                <p><i class="fas fa-map-marker-alt"></i> Địa chỉ</p>
                                <strong>Công Ty TNHH ENERGY Mặt Trời Việt</strong>
                            </div>

                            <div class="contact-info-item">
                                <p><i class="fas fa-clock"></i> Giờ làm việc</p>
                                <span>Thứ 2 - Thứ 6: 8:00 - 18:00<br>Thứ 7 - Chủ Nhật: 9:00 - 17:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
