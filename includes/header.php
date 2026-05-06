<?php
// includes/header.php
// Header chung cho tất cả trang (Public + Admin)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Năng Lượng Mặt Trời' : 'Năng Lượng Mặt Trời'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/modern.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="/" class="logo">
                    <i class="fas fa-sun logo-icon"></i>
                    <span class="logo-text">ENERGY Mặt Trời</span>
                </a>
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/" class="nav-link">Trang chủ</a></li>
                <li><a href="/san-pham" class="nav-link">Sản phẩm</a></li>
                <li><a href="/du-an" class="nav-link">Dự án</a></li>
                <li><a href="/tin-tuc" class="nav-link">Tin tức</a></li>
                <li><a href="/lien-he" class="nav-link nav-link-contact">
                    <i class="fas fa-phone"></i> Liên hệ
                </a></li>
            </ul>
        </div>
    </nav>
    <div class="page-content">