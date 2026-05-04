<?php
// includes/footer.php
// Footer chung cho tất cả trang
?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section footer-brand-block">
                    <h3>Công Ty TNHH ENERGY Mặt Trời Việt</h3>
                    <p>Cung cấp giải pháp điện mặt trời, lưu trữ và tối ưu chi phí cho gia đình, nhà xưởng và doanh nghiệp.</p>

                    <div class="footer-highlights">
                        <span><i class="fas fa-check-circle"></i> Khảo sát tận nơi</span>
                        <span><i class="fas fa-check-circle"></i> Thi công trọn gói</span>
                        <span><i class="fas fa-check-circle"></i> Bảo hành rõ ràng</span>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Liên hệ nhanh</h3>
                    <div class="footer-contact-list">
                        <p><i class="fas fa-phone"></i> <a href="tel:0789686565">0789686565</a></p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:info@solar.vn">info@solar.vn</a></p>
                        <p><i class="fas fa-clock"></i> 8:00 - 18:00, Thứ 2 - Chủ nhật</p>
                    </div>
                    <div class="social footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="footer-section footer-map-section">
                    <h3>Bản đồ & địa chỉ</h3>
                    <div class="footer-map-embed">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.9142691353354!2d105.77102057457259!3d10.023933290082686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0890004c001ad%3A0x8b322112e95e558b!2zQ8O0bmcgVHkgVE5ISCBFTkVSR1kgTeG6t3QgVHLhu51pIFZp4buHdA!5e0!3m2!1svi!2s!4v1777299663870!5m2!1svi!2s"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                            title="Bản đồ Công Ty TNHH ENERGY Mặt Trời Việt"></iframe>
                    </div>
                    <p class="footer-address"><i class="fas fa-map-marker-alt"></i> Công Ty TNHH ENERGY Mặt Trời Việt</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Solar Energy. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <!-- Contact Widget -->
    <?php if(file_exists(__DIR__ . '/contact-widget.php') && strpos($_SERVER['PHP_SELF'], '/admin/') === false && basename($_SERVER['PHP_SELF']) !== 'login.php') { include __DIR__ . '/contact-widget.php'; } ?>

    <script src="/assets/js/script.js"></script>
</body>
</html>
