<?php
// index.php
session_start();
require_once 'config/db.php';

$page_title = 'Trang chủ';
include 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="hero-pill"><i class="fas fa-bolt"></i> Giải pháp điện mặt trời cho gia đình, doanh nghiệp và nhà xưởng</div>
        <h1>Năng Lượng Mặt Trời Tương Lai</h1>
        <p>Mang đến giải pháp năng lượng xanh tối ưu, tiết kiệm chi phí và bảo vệ môi trường cho gia đình & doanh nghiệp của bạn.</p>
        <div class="hero-buttons">
            <a href="/san-pham" class="btn btn-light">Khám phá sản phẩm</a>
            <a href="/lien-he" class="btn btn-outline">Nhận tư vấn ngay</a>
        </div>
    </div>
</section>

<section class="section hero-stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stats-card">
                <span class="stats-value"><?php echo count(get_table_data('projects')); ?>+</span>
                <span class="stats-label">Dự án đã triển khai</span>
            </div>
            <div class="stats-card">
                <span class="stats-value"><?php echo count(get_table_data('products')); ?>+</span>
                <span class="stats-label">Sản phẩm / giải pháp</span>
            </div>
            <div class="stats-card">
                <span class="stats-value"><?php echo count(get_table_data('posts')); ?>+</span>
                <span class="stats-label">Bài viết kiến thức</span>
            </div>
            <div class="stats-card stats-card-highlight">
                <span class="stats-value">24/7</span>
                <span class="stats-label">Hỗ trợ liên hệ nhanh</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-vision bg-light">
    <div class="container">
        <div class="section-header">
            <h2>Triển khai rõ ràng, vận hành bền vững</h2>
            <p>Tham chiếu bố cục giàu nội dung từ các website năng lượng mặt trời hiện đại nhưng vẫn giữ tông xanh chủ đạo của thương hiệu.</p>
        </div>
        <div class="feature-grid">
            <div class="feature-card">
                <i class="fas fa-sun feature-icon"></i>
                <h3>Khảo sát & tư vấn</h3>
                <p>Đề xuất hệ thống phù hợp nhu cầu sử dụng, diện tích mái và ngân sách đầu tư.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-cubes feature-icon"></i>
                <h3>Thi công trọn gói</h3>
                <p>Thiết kế, lắp đặt và bàn giao theo quy trình rõ ràng, ưu tiên độ an toàn và thẩm mỹ.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-shield-halved feature-icon"></i>
                <h3>Bảo hành dài hạn</h3>
                <p>Đồng hành sau triển khai bằng hỗ trợ kỹ thuật, bảo trì và theo dõi hiệu suất.</p>
            </div>
        </div>
    </div>
</section>

<section class="section bg-light">
    <div class="container">
        <div class="section-header">
            <h2>Sản phẩm nổi bật</h2>
            <p>Các thiết bị năng lượng mặt trời công nghệ mới nhất với hiệu suất vượt trội.</p>
        </div>
        
        <?php
        $products = array_slice(get_table_data('products'), 0, 3);
        if (!empty($products)): 
        ?>
            <div class="grid">
                <?php foreach($products as $product): ?>
                    <div class="card">
                        <div class="card-image-wrapper">
                            <?php if(!empty($product['image']) && file_exists('uploads/' . $product['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product" class="card-image" loading="lazy">
                            <?php else: ?>
                                <div class="card-image-placeholder"><i class="fas fa-solar-panel"></i></div>
                            <?php endif; ?>
                            <?php if(!empty($product['power'])): ?>
                                <div class="card-badge"><?php echo htmlspecialchars($product['power']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="desc"><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="card-footer">
                                <span class="price"><?php echo htmlspecialchars($product['price']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-3">
                <a href="/san-pham" class="btn btn-primary">Xem tất cả sản phẩm <i class="fas fa-arrow-right"></i></a>
            </div>
        <?php else: ?>
            <div class="empty-state text-center" style="padding: 3rem 0; color: var(--text-muted);">
                <i class="fas fa-box-open" style="font-size: 4rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Hiện tại chưa có sản phẩm nổi bật nào. Đang cập nhật thêm...</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Dự án tiêu biểu</h2>
            <p>Hàng ngàn khách hàng đã tin tưởng và sử dụng hệ thống của chúng tôi.</p>
        </div>
        
        <?php
        $projects = array_slice(get_table_data('projects'), 0, 3);
        if (!empty($projects)): 
        ?>
            <div class="grid">
                <?php foreach($projects as $project): ?>
                    <div class="card project-card">
                        <div class="card-image-wrapper">
                            <?php if(!empty($project['image']) && file_exists('uploads/' . $project['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($project['image']); ?>" alt="Project" class="card-image" loading="lazy">
                            <?php else: ?>
                                <div class="card-image-placeholder"><i class="fas fa-building"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($project['name']); ?></h3>
                            <div class="project-meta">
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location'] ?? 'Đang cập nhật'); ?></span>
                                <span><i class="fas fa-bolt"></i> <?php echo htmlspecialchars($project['capacity'] ?? ''); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state text-center" style="padding: 3rem 0; color: var(--text-muted);">
                <i class="fas fa-clipboard-list" style="font-size: 4rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Các dự án mới nhất sẽ sớm được cập nhật tại đây.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Sẵn sàng chuyển sang năng lượng sạch?</h2>
        <p>Liên hệ với chuyên gia của chúng tôi để được khảo sát và tư vấn hoàn toàn miễn phí.</p>
        <a href="/lien-he" class="btn btn-light btn-lg">Bắt đầu ngay hôm nay</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>