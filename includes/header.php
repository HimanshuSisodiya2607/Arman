<?php
/**
 * Shared header – same theme as landing (navbar, fonts, colors).
 * $page_title and $is_admin optional.
 */
$page_title     = isset($page_title) ? $page_title : 'VocalFluxStudio';
$is_admin       = isset($is_admin) && $is_admin;
$is_login_page  = !empty($is_login_page);
$base           = ($is_admin || $is_login_page) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <title><?php echo htmlspecialchars($page_title); ?> | VocalFluxStudio</title>
    <link rel="icon" type="image/png" href="<?php echo $base; ?>logo.jpg" />
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>styles.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/app.css">
    <?php if (!empty($extra_css)) { echo $extra_css; } ?>
</head>
<body>
    <nav id="navbar" class="navbar scrolled">
        <div class="container">
            <div class="nav-content">
                <a href="<?php echo $base ? $base . 'index.html' : 'index.html'; ?>" class="logo">
                    <div class="logo-icon">
                        <img src="<?php echo $base; ?>logo.jpg" alt="VocalFluxStudio">
                    </div>
                    <div class="logo-text">
                        <span class="logo-main">VOCAL<span class="logo-accent">FLUX</span></span>
                        <span class="logo-sub">Studio</span>
                    </div>
                </a>
                <?php if ($is_admin): ?>
                <div class="nav-links">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="add-link.php">Add Link</a>
                    <a href="enquiries.php">Enquiries</a>
                </div>
                <div class="nav-actions">
                    <a href="logout.php" class="btn-ghost">Logout</a>
                </div>
                <?php elseif (!$is_login_page): ?>
                <div class="nav-links">
                    <a href="index.html">Home</a>
                    <a href="index.php">Links</a>
                    <a href="admin/login.php">Admin</a>
                </div>
                <div class="nav-actions">
                    <a href="auth.html" class="btn-ghost">Login</a>
                    <a href="admin/login.php" class="btn-ghost">Admin</a>
                    <a href="index.php#enquiry" class="btn-primary">Enquiry</a>
                </div>
                <?php endif; ?>
                <?php if (!$is_login_page): ?>
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($is_admin): ?>
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-content">
                <a href="dashboard.php" class="mobile-link">Dashboard</a>
                <a href="add-link.php" class="mobile-link">Add Link</a>
                <a href="enquiries.php" class="mobile-link">Enquiries</a>
                <a href="logout.php" class="btn-primary-mobile">Logout</a>
            </div>
        </div>
        <?php elseif (!$is_login_page): ?>
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-content">
                <a href="index.html" class="mobile-link">Home</a>
                <a href="index.php" class="mobile-link">Links</a>
                <a href="admin/login.php" class="mobile-link">Admin</a>
                <a href="auth.html" class="btn-outline-mobile">Login</a>
                <a href="index.php#enquiry" class="btn-primary-mobile">Enquiry</a>
            </div>
        </div>
        <?php endif; ?>
    </nav>
