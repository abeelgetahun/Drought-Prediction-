<?php
// This file assumes session_start() has been called by the parent file
// and $_SESSION['loggedin'] and $_SESSION['username'] are set.
if (!isset($_SESSION['loggedin'])) {
    // In case this is somehow accessed directly or session is lost.
    header('Location: login.php');
    exit;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <i class="fas fa-tachometer-alt me-2"></i>Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'news') !== false) ? 'active' : ''; ?>" href="manage_news.php">
                        <i class="fas fa-newspaper me-1"></i> News
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'event') !== false) ? 'active' : ''; ?>" href="manage_events.php">
                        <i class="fas fa-calendar-alt me-1"></i> Events
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'researcher') !== false) ? 'active' : ''; ?>" href="manage_researchers.php">
                        <i class="fas fa-users me-1"></i> Researchers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'storie') !== false) ? 'active' : ''; ?>" href="manage_stories.php">
                        <i class="fas fa-book-open me-1"></i> Stories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'focus') !== false) ? 'active' : ''; ?>" href="manage_focus.php">
                        <i class="fas fa-bullseye me-1"></i> Focus Areas
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>