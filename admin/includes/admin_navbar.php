<?php
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark admin-navbar fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand brand-modern" href="dashboard.php">
            <div class="brand-icon">
                <i class="fas fa-cloud-rain"></i>
            </div>
            <div class="brand-text">
                <span class="brand-title">Drought Prediction</span>
                <span class="brand-subtitle">Admin Panel</span>
            </div>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'news') !== false) ? 'active' : ''; ?>" href="manage_news.php">
                        <i class="fas fa-newspaper"></i>
                        <span>News</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'event') !== false) ? 'active' : ''; ?>" href="manage_events.php">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'researcher') !== false) ? 'active' : ''; ?>" href="manage_researchers.php">
                        <i class="fas fa-users"></i>
                        <span>Researchers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'storie') !== false) ? 'active' : ''; ?>" href="manage_stories.php">
                        <i class="fas fa-book-open"></i>
                        <span>Stories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'focus') !== false) ? 'active' : ''; ?>" href="manage_focus.php">
                        <i class="fas fa-bullseye"></i>
                        <span>Focus Areas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-modern <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'analytics') !== false) ? 'active' : ''; ?>" href="analytics.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-menu-modern" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username']); ?>&background=667eea&color=fff" alt="User Avatar">
                        </div>
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-cog me-2"></i>
                                Profile Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>
                                System Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
