<?php
/**
 * Contact Widget - Nút liên hệ nhanh cố định ở góc phải.
 */
?>

<!-- Contact Widget CSS -->
<style>
    /* Contact Widget Container */
    .contact-widget {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 999;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Widget Hidden by Default */
    .widget-collapsed,
    .widget-expanded {
        width: 74px;
        height: 74px;
    }

    /* Toggle Button */
    .contact-toggle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        font-size: 28px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .contact-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    }

    .contact-toggle i {
        transition: transform 0.3s ease;
    }

    .widget-expanded .contact-toggle i {
        transform: rotate(45deg);
    }

    /* Widget Panel */
    .widget-panel {
        background: white;
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(2, 6, 23, 0.18);
        display: none;
        flex-direction: column;
        overflow: hidden;
        margin-bottom: 88px;
        animation: slideUp 0.25s ease;
    }

    .widget-expanded .widget-panel {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .widget-panel-header {
        padding: 1rem 1rem 0.75rem;
        background: linear-gradient(135deg, #0f172a 0%, #0f766e 100%);
        color: white;
    }

    .widget-panel-header h4 {
        margin: 0 0 0.35rem;
        font-size: 1rem;
    }

    .widget-panel-header p {
        margin: 0;
        font-size: 0.82rem;
        opacity: 0.92;
    }

    /* Contact List */
    .contact-list {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .contact-btn {
        padding: 12px 14px;
        border: 1px solid #dbe4ef;
        background: #fff;
        border-radius: 14px;
        cursor: pointer;
        text-align: left;
        transition: all 0.25s ease;
        font-size: 13px;
        font-weight: 700;
    }

    .contact-btn:hover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
        color: #10b981;
    }

    .contact-btn i {
        margin-right: 8px;
    }

    .widget-quick-contact {
        padding: 0 1rem 1rem;
        display: grid;
        gap: 0.6rem;
    }

    .widget-quick-contact .contact-btn {
        width: 100%;
        justify-content: center;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Mobile Responsive */
    @media (max-width: 640px) {
        .contact-widget {
            bottom: 1rem;
            right: 1rem;
        }

        .widget-panel {
            margin-bottom: 78px;
            width: min(100vw - 2rem, 360px);
        }
    }
</style>

<!-- Contact Widget HTML -->
<div class="contact-widget" id="contactWidget">
    <!-- Toggle Button -->
    <button class="contact-toggle" id="contactToggle" title="Liên hệ">
        <i class="fas fa-comment-dots"></i>
    </button>

    <!-- Widget Panel -->
    <div class="widget-panel">
        <div class="widget-panel-header">
            <h4>Liên hệ nhanh</h4>
            <p>Để lại liên hệ hoặc gọi ngay để được tư vấn.</p>
        </div>
        <div class="contact-list">
            <button class="contact-btn" onclick="window.location.href='tel:0789686565'">
                <i class="fas fa-phone"></i> Gọi ngay 0789686565
            </button>
            <button class="contact-btn" onclick="window.location.href='/lien-he'">
                <i class="fas fa-pen-to-square"></i> Để lại liên hệ
            </button>
            <button class="contact-btn" onclick="window.location.href='mailto:info@solar.vn'">
                <i class="fas fa-envelope"></i> Gửi email
            </button>
            <button class="contact-btn" onclick="window.location.href='https://maps.app.goo.gl/V8geD9qtEMJe6M1P8'">
                <i class="fas fa-map-location-dot"></i> Xem chỉ đường
            </button>
        </div>
    </div>
</div>

<!-- Contact Widget Script -->
<script>
    // Initialize Widget
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('contactToggle');
        const widget = document.getElementById('contactWidget');

        // Toggle Widget
        toggle.addEventListener('click', function() {
            widget.classList.toggle('widget-expanded');
        });

        // Close widget on page change (optional)
        window.addEventListener('click', function(e) {
            if(!widget.contains(e.target) && !toggle.contains(e.target)) {
                // Optionally close widget when clicking outside
                // widget.classList.remove('widget-expanded');
            }
        });
    });

</script>
