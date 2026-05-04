<?php
$admin_layout = $admin_layout ?? 'panel';
$admin_page_title = $page_title ?? 'Admin';
$admin_section_title = $admin_section_title ?? $admin_page_title;
$admin_section_description = $admin_section_description ?? '';
$admin_nav_active = $admin_nav_active ?? '';
$messages_count = $messages_count ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($admin_page_title); ?> - Năng Lượng Mặt Trời</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="<?php echo $admin_layout === 'auth' ? 'admin-auth-body' : 'admin-body'; ?>">
<?php if($admin_layout === 'auth'): ?>
    <main class="auth-main">
        <div class="container auth-container">
<?php else: ?>
    <header class="admin-shell">
        <nav class="navbar admin-navbar">
            <div class="container admin-navbar-inner">
                <a href="/admin/dashboard.php" class="logo admin-logo">
                    <i class="fas fa-sun"></i>
                    <span>Solar Energy Admin</span>
                </a>
                <div class="admin-nav">
                    <a href="dashboard.php" class="<?php echo $admin_nav_active === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
                    <a href="products.php" class="<?php echo $admin_nav_active === 'products' ? 'active' : ''; ?>">Sản phẩm</a>
                    <a href="posts.php" class="<?php echo $admin_nav_active === 'posts' ? 'active' : ''; ?>">Tin tức</a>
                    <a href="projects.php" class="<?php echo $admin_nav_active === 'projects' ? 'active' : ''; ?>">Dự án</a>
                    <a href="messages.php" class="<?php echo $admin_nav_active === 'messages' ? 'active' : ''; ?>">Liên hệ <?php echo $messages_count ? '(' . (int)$messages_count . ')' : ''; ?></a>
                    <a href="logout.php" class="admin-nav-logout">Đăng xuất</a>
                </div>
            </div>
        </nav>

        <section class="admin-hero">
            <div class="container admin-hero-inner">
                <div>
                    <p class="admin-kicker">Khu quản trị nội dung</p>
                    <h1><?php echo htmlspecialchars($admin_section_title); ?></h1>
                    <?php if(!empty($admin_section_description)): ?>
                        <p><?php echo htmlspecialchars($admin_section_description); ?></p>
                    <?php endif; ?>
                </div>
                <a href="/" class="btn btn-light admin-back-link"><i class="fas fa-arrow-left"></i> Xem website</a>
            </div>
        </section>

        <main class="admin-main">
            <div class="container admin-content">
<?php endif; ?>