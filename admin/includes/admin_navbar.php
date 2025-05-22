<?php
// This file assumes session_start() has been called by the parent file
// and $_SESSION['loggedin'] and $_SESSION['username'] are set.
if (!isset($_SESSION['loggedin'])) {
    // In case this is somehow accessed directly or session is lost.
    header('Location: login.php');
    exit;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'news') !== false) ? 'active' : ''; ?>" href="manage_news.php">Manage News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'event') !== false) ? 'active' : ''; ?>" href="manage_events.php">Manage Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'researcher') !== false) ? 'active' : ''; ?>" href="manage_researchers.php">Manage Researchers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'storie') !== false) ? 'active' : ''; ?>" href="manage_stories.php">Manage Stories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos(basename($_SERVER['PHP_SELF']), 'focus') !== false) ? 'active' : ''; ?>" href="manage_focus.php">Manage Focus Areas</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="navbar-text">
                        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
