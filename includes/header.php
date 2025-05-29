<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'DroughtWatch - Monitor Drought Conditions'; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'DroughtWatch provides real-time monitoring and analysis of drought conditions through advanced data visualization and research.'; ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo isset($cssPath) ? $cssPath : '../'; ?>assets/css/theme-style.css">
</head>
<body>
    <!-- Single Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo isset($basePath) ? $basePath : '../'; ?>index.php">
                DroughtWatch
            </a>
            
            <!-- Right Side Navigation and Controls -->
            <div class="d-flex align-items-center ms-auto">
                <!-- Desktop Navigation Links -->
                <div class="d-none d-lg-block me-4">
                    <ul class="page-indicators">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" 
                               href="<?php echo isset($basePath) ? $basePath : '../'; ?>index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'researchers.php') ? 'active' : ''; ?>" 
                               href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/researchers.php">Research</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'news.php') ? 'active' : ''; ?>" 
                               href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/news.php">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'events.php') ? 'active' : ''; ?>" 
                               href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/events.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'stories.php') ? 'active' : ''; ?>" 
                               href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/stories.php">Stories</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Search Icon -->
                <button class="nav-icon me-2" id="searchToggle" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
                
                <!-- Theme Toggle -->
                <button class="theme-toggle me-2" id="themeToggle" aria-label="Toggle theme">
                    <i class="fas fa-sun"></i>
                    <i class="fas fa-moon"></i>
                </button>
                
                <!-- Mobile Menu Toggle -->
                <button class="nav-icon d-lg-none" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            
        </div>
    </nav>

    <!-- Inline Search Panel -->
    <div class="search-panel" id="searchPanel">
        <div class="container">
            <div class="search-panel-content">
                <div class="search-header">
                    <h5>Search DroughtWatch</h5>
                    <button class="search-panel-close" id="searchPanelClose">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="search-input-container">
                    <input type="text" id="liveSearchInput" class="search-input-live" placeholder="Start typing to search..." autocomplete="off">
                    <div class="search-filters">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="news">News</button>
                        <button class="filter-btn" data-filter="events">Events</button>
                        <button class="filter-btn" data-filter="researchers">Researchers</button>
                        <button class="filter-btn" data-filter="stories">Stories</button>
                        <button class="filter-btn" data-filter="focus">Focus Areas</button>
                    </div>
                </div>
                
                <div class="search-results-container">
                    <div id="searchResults" class="search-results-live">
                        <div class="search-placeholder">
                            <i class="fas fa-search fa-2x mb-3"></i>
                            <p>Start typing to search across all content...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>