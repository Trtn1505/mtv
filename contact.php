<?php
// contact.php
// Trang liên hệ - Redesigned

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
                    <div class="alert alert-success fade-in" style="margin-bottom: 2rem;">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Cảm ơn bạn!</strong>
                            <p>Chúng tôi sẽ liên lạc lại với bạn sớm nhất.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($error): ?>
                    <div class="alert alert-danger fade-in" style="margin-bottom: 2rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Lỗi!</strong>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card contact-card modern-card">
                    <div class="card-content">
                        <h3 class="contact-form-title">
                            <i class="fas fa-phone-volume"></i>
                            Gửi liên hệ cho chúng tôi
                        </h3>
                        
                        <form method="POST" action="" class="modern-form">
                            <div class="form-group">
                                <label for="name">Tên của bạn <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" 
                                        placeholder="Nhập tên của bạn"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-mobile-alt"></i>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); }}" 
                                        placeholder="09xx-xxx-xxx"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fas fa-envelope"></i>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); }}" 
                                        placeholder="email@example.com"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Nội dung cần hỗ trợ <span class="required">*</span></label>
                                <div class="input-wrapper textarea-wrapper">
                                    <i class="fas fa-comment-dots"></i>
                                    <textarea 
                                        id="message" 
                                        name="message" 
                                        style="min-height: 140px;" 
                                        placeholder="Mô tả chi tiết nhu cầu của bạn..."
                                        required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit" style="width: 100%;">
                                <i class="fas fa-paper-plane"></i>
                                <span>Gửi liên hệ ngay</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="contact-info-column">
                <div class="card contact-info-card modern-card">
                    <div class="card-content">
                        <h3><i class="fas fa-building"></i> Thông tin công ty</h3>
                        
                        <div class="contact-info-stack">
                            <div class="contact-info-item contact-info-item-primary">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p>Điện thoại</p>
                                    <a href="tel:0789686565" class="contact-link">0789686565</a>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p>Email</p>
                                    <a href="mailto:info@solar.vn" class="contact-link">info@solar.vn</a>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p>Địa chỉ</p>
                                    <strong>Công Ty TNHH ENERGY<br>Mặt Trời Việt</strong>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p>Giờ làm việc</p>
                                    <span>T2-T6: 8:00-18:00<br>T7-CN: 9:00-17:00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Contact Buttons -->
                        <div class="contact-quick-buttons">
                            <a href="tel:0789686565" class="btn btn-small btn-outline">
                                <i class="fas fa-phone"></i> Gọi ngay
                            </a>
                            <a href="https://zalo.me/0789686565" target="_blank" class="btn btn-small btn-outline">
                                <i class="fab fa-zalo"></i> Zalo
                            </a>
                            <a href="https://m.facebook.com" target="_blank" class="btn btn-small btn-outline">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>