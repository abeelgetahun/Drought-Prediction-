<?php
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Include the database configuration
require_once '../config/db.php';

// Count stats for dashboard
$stats = array();

// Count news
$result = $mysqli->query("SELECT COUNT(*) as count FROM news");
$stats['news'] = $result ? $result->fetch_assoc()['count'] : 0;

// Count events
$result = $mysqli->query("SELECT COUNT(*) as count FROM events");
$stats['events'] = $result ? $result->fetch_assoc()['count'] : 0;

// Count researchers
$result = $mysqli->query("SELECT COUNT(*) as count FROM researchers");
$stats['researchers'] = $result ? $result->fetch_assoc()['count'] : 0;

// Count stories
$result = $mysqli->query("SELECT COUNT(*) as count FROM stories");
$stats['stories'] = $result ? $result->fetch_assoc()['count'] : 0;

// Count focus areas
$result = $mysqli->query("SELECT COUNT(*) as count FROM focus");
$stats['focus'] = $result ? $result->fetch_assoc()['count'] : 0;

// Get monthly data for charts (last 6 months)
$monthly_data = array();
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $month_name = date('M Y', strtotime("-$i months"));
    
    // Count news for this month
    $result = $mysqli->query("SELECT COUNT(*) as count FROM news WHERE DATE_FORMAT(publish_date, '%Y-%m') = '$month'");
    $news_count = $result ? $result->fetch_assoc()['count'] : 0;
    
    // Count events for this month
    $result = $mysqli->query("SELECT COUNT(*) as count FROM events WHERE DATE_FORMAT(event_date, '%Y-%m') = '$month'");
    $events_count = $result ? $result->fetch_assoc()['count'] : 0;
    
    // Count stories for this month
    $result = $mysqli->query("SELECT COUNT(*) as count FROM stories WHERE DATE_FORMAT(publish_date, '%Y-%m') = '$month'");
    $stories_count = $result ? $result->fetch_assoc()['count'] : 0;
    
    $monthly_data[] = array(
        'month' => $month_name,
        'news' => $news_count,
        'events' => $events_count,
        'stories' => $stories_count
    );
}

// Get recent activities (latest 5 news)
$recent_news = array();
$result = $mysqli->query("SELECT id, title, publish_date FROM news ORDER BY publish_date DESC LIMIT 5");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recent_news[] = $row;
    }
}

// Get upcoming events (next 5 events)
$upcoming_events = array();
$result = $mysqli->query("SELECT id, name, event_date FROM events WHERE event_date >= NOW() ORDER BY event_date ASC LIMIT 5");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $upcoming_events[] = $row;
    }
}

// Get recent stories
$recent_stories = array();
$result = $mysqli->query("SELECT id, title, author, publish_date FROM stories ORDER BY publish_date DESC LIMIT 3");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recent_stories[] = $row;
    }
}

// Get content distribution for pie chart
$content_distribution = array(
    'News' => $stats['news'],
    'Events' => $stats['events'],
    'Researchers' => $stats['researchers'],
    'Stories' => $stats['stories'],
    'Focus Areas' => $stats['focus']
);

// Calculate growth percentages (comparing with previous month)
$growth_data = array();
$prev_month = date('Y-m', strtotime("-1 months"));
$current_month = date('Y-m');

foreach (['news', 'events', 'stories'] as $table) {
    $current_result = $mysqli->query("SELECT COUNT(*) as count FROM $table WHERE DATE_FORMAT(" . ($table == 'events' ? 'event_date' : 'publish_date') . ", '%Y-%m') = '$current_month'");
    $current_count = $current_result ? $current_result->fetch_assoc()['count'] : 0;
    
    $prev_result = $mysqli->query("SELECT COUNT(*) as count FROM $table WHERE DATE_FORMAT(" . ($table == 'events' ? 'event_date' : 'publish_date') . ", '%Y-%m') = '$prev_month'");
    $prev_count = $prev_result ? $prev_result->fetch_assoc()['count'] : 0;
    
    $growth = $prev_count > 0 ? (($current_count - $prev_count) / $prev_count) * 100 : 0;
    $growth_data[$table] = round($growth, 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Drought Prediction System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    
    <style>
        :root {
            --primary-color: #1e293b;
            --secondary-color: #3b82f6;
            --accent-color: #ef4444;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --light-color: #f8fafc;
            --dark-color: #0f172a;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
            --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding-bottom: 80px;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #334155 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            border-radius: 8px;
            margin: 0 4px;
            padding: 8px 16px !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white !important;
            background: rgba(255,255,255,0.15);
            transform: translateY(-1px);
        }
        
        .main-content {
            padding-top: 100px;
        }
        
        .dashboard-header {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }
        
        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .dashboard-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color) 0%, var(--card-color-light) 100%);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        
        .stat-card.news-card {
            --card-color: var(--secondary-color);
            --card-color-light: #93c5fd;
        }
        
        .stat-card.events-card {
            --card-color: var(--warning-color);
            --card-color-light: #fbbf24;
        }
        
        .stat-card.researchers-card {
            --card-color: var(--info-color);
            --card-color-light: #67e8f9;
        }
        
        .stat-card.stories-card {
            --card-color: var(--success-color);
            --card-color-light: #6ee7b7;
        }
        
        .stat-card.focus-card {
            --card-color: var(--accent-color);
            --card-color-light: #fca5a5;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-light) 100%);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
            line-height: 1;
        }
        
        .stat-label {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .growth-indicator {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-top: 0.5rem;
            display: inline-block;
        }
        
        .growth-positive {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
        
        .growth-negative {
            background: rgba(239, 68, 68, 0.1);
            color: var(--accent-color);
        }
        
        .growth-neutral {
            background: rgba(100, 116, 139, 0.1);
            color: var(--text-muted);
        }
        
        .chart-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }
        
        .chart-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        .chart-container.pie-chart {
            height: 400px;
        }
        
        .activity-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .activity-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #334155 100%);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        .activity-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }
        
        .activity-item:hover {
            background-color: #f8fafc;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-title {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        
        .activity-date {
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        
        .quick-action-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .quick-action-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        
        .quick-action-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--action-color) 0%, var(--action-color-light) 100%);
        }
        
        .quick-action-card.news-action {
            --action-color: var(--secondary-color);
            --action-color-light: #93c5fd;
        }
        
        .quick-action-card.events-action {
            --action-color: var(--warning-color);
            --action-color-light: #fbbf24;
        }
        
        .quick-action-card.researchers-action {
            --action-color: var(--info-color);
            --action-color-light: #67e8f9;
        }
        
        .footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, #334155 100%);
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 1rem 0;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2563eb 100%);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .chart-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Loading animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .chart-card {
            animation: slideInRight 0.8s ease forwards;
        }
        
        @media (max-width: 1200px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .metric-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
            
            .dashboard-header {
                padding: 1.5rem;
            }
            
            .dashboard-title {
                font-size: 1.75rem;
            }
            
            .activity-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding-top: 80px;
            }
            
            .dashboard-header {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .dashboard-title {
                font-size: 1.5rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-number {
                font-size: 1.75rem;
            }
            
            .chart-card {
                padding: 1rem;
            }
            
            .chart-container {
                height: 250px;
            }
        }
        
        /* Accessibility improvements */
        .stat-card:focus-within,
        .quick-action-card:focus-within {
            outline: 2px solid var(--secondary-color);
            outline-offset: 2px;
        }
        
        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navigation Bar -->
    <?php include 'includes/admin_navbar.php'; ?>

    <div class="container-fluid main-content">
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="dashboard-title">
                        <i class="fas fa-chart-line me-3"></i>
                        Dashboard Overview
                    </h1>
                    <p class="dashboard-subtitle">
                        Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>! 
                        Here's what's happening with your drought watch system.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <i class="fas fa-calendar-alt me-2 text-muted"></i>
                        <span class="text-muted"><?php echo date('F j, Y'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>' . $_SESSION['success_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>' . $_SESSION['error_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <!-- Statistics Cards -->
        <div class="metric-grid">
            <div class="stat-card news-card" data-target="<?php echo $stats['news']; ?>">
                <div class="stat-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">News Articles</div>
                <?php if (isset($growth_data['news'])): ?>
                    <div class="growth-indicator <?php echo $growth_data['news'] > 0 ? 'growth-positive' : ($growth_data['news'] < 0 ? 'growth-negative' : 'growth-neutral'); ?>">
                        <i class="fas fa-<?php echo $growth_data['news'] > 0 ? 'arrow-up' : ($growth_data['news'] < 0 ? 'arrow-down' : 'minus'); ?>"></i>
                        <?php echo abs($growth_data['news']); ?>% this month
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="stat-card events-card" data-target="<?php echo $stats['events']; ?>">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Events</div>
                <?php if (isset($growth_data['events'])): ?>
                    <div class="growth-indicator <?php echo $growth_data['events'] > 0 ? 'growth-positive' : ($growth_data['events'] < 0 ? 'growth-negative' : 'growth-neutral'); ?>">
                        <i class="fas fa-<?php echo $growth_data['events'] > 0 ? 'arrow-up' : ($growth_data['events'] < 0 ? 'arrow-down' : 'minus'); ?>"></i>
                        <?php echo abs($growth_data['events']); ?>% this month
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="stat-card researchers-card" data-target="<?php echo $stats['researchers']; ?>">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Researchers</div>
            </div>
            
            <div class="stat-card stories-card" data-target="<?php echo $stats['stories']; ?>">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Stories</div>
                <?php if (isset($growth_data['stories'])): ?>
                    <div class="growth-indicator <?php echo $growth_data['stories'] > 0 ? 'growth-positive' : ($growth_data['stories'] < 0 ? 'growth-negative' : 'growth-neutral'); ?>">
                        <i class="fas fa-<?php echo $growth_data['stories'] > 0 ? 'arrow-up' : ($growth_data['stories'] < 0 ? 'arrow-down' : 'minus'); ?>"></i>
                        <?php echo abs($growth_data['stories']); ?>% this month
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="stat-card focus-card" data-target="<?php echo $stats['focus']; ?>">
                <div class="stat-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Focus Areas</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="chart-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-line me-2"></i>
                        Content Trends (Last 6 Months)
                    </h3>
                </div>
                <div class="chart-container">
                    <canvas id="trendsChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie me-2"></i>
                        Content Distribution
                    </h3>
                </div>
                <div class="chart-container pie-chart">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="activity-grid">
            <div class="activity-card">
                <div class="activity-header">
                    <i class="fas fa-rss me-2"></i>
                    Recent News
                </div>
                <?php if (empty($recent_news)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-newspaper fa-3x mb-3 opacity-50"></i>
                        <p>No recent news found.</p>
                        <a href="manage_news.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add News
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($recent_news as $news): ?>
                        <div class="activity-item">
                            <div class="activity-title"><?php echo htmlspecialchars($news['title']); ?></div>
                            <div class="activity-date">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo date('M j, Y', strtotime($news['publish_date'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="p-3 text-center border-top">
                        <a href="manage_news.php" class="btn btn-primary btn-sm">
                            View All News
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="activity-card">
                <div class="activity-header">
                    <i class="fas fa-calendar me-2"></i>
                    Upcoming Events
                </div>
                <?php if (empty($upcoming_events)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-calendar-alt fa-3x mb-3 opacity-50"></i>
                        <p>No upcoming events found.</p>
                        <a href="manage_events.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Event
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($upcoming_events as $event): ?>
                        <div class="activity-item">
                            <div class="activity-title"><?php echo htmlspecialchars($event['name']); ?></div>
                            <div class="activity-date">
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo date('M j, Y', strtotime($event['event_date'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="p-3 text-center border-top">
                        <a href="manage_events.php" class="btn btn-primary btn-sm">
                            View All Events
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="activity-card">
                <div class="activity-header">
                    <i class="fas fa-book-open me-2"></i>
                    Recent Stories
                </div>
                <?php if (empty($recent_stories)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-book-open fa-3x mb-3 opacity-50"></i>
                        <p>No recent stories found.</p>
                        <a href="manage_stories.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Story
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($recent_stories as $story): ?>
                        <div class="activity-item">
                            <div class="activity-title"><?php echo htmlspecialchars($story['title']); ?></div>
                            <div class="activity-date">
                                <i class="fas fa-user me-1"></i>
                                <?php echo htmlspecialchars($story['author']); ?> • 
                                <?php echo date('M j, Y', strtotime($story['publish_date'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="p-3 text-center border-top">
                        <a href="manage_stories.php" class="btn btn-primary btn-sm">
                            View All Stories
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="h4 text-dark fw-bold">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h2>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="quick-action-card news-action">
                    <div class="quick-action-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Manage News</h5>
                    <p class="text-muted mb-3">Create, edit, and publish news articles</p>
                    <a href="manage_news.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Go to News
                    </a>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="quick-action-card events-action">
                    <div class="quick-action-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Manage Events</h5>
                    <p class="text-muted mb-3">Schedule and organize events</p>
                    <a href="manage_events.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Go to Events
                    </a>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="quick-action-card researchers-action">
                    <div class="quick-action-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Manage Researchers</h5>
                    <p class="text-muted mb-3">Update researcher profiles</p>
                    <a href="manage_researchers.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Go to Researchers
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include 'includes/admin_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
        // Chart.js Configuration
        Chart.defaults.font.family = 'Inter';
        Chart.defaults.color = '#64748b';

        // Monthly Trends Chart
        const trendsCtx = document.getElementById('trendsChart').getContext('2d');
        const trendsChart = new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthly_data, 'month')); ?>,
                datasets: [{
                    label: 'News Articles',
                    data: <?php echo json_encode(array_column($monthly_data, 'news')); ?>,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }, {
                    label: 'Events',
                    data: <?php echo json_encode(array_column($monthly_data, 'events')); ?>,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }, {
                    label: 'Stories',
                    data: <?php echo json_encode(array_column($monthly_data, 'stories')); ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const element = elements[0];
                        const datasetIndex = element.datasetIndex;
                        const datasets = ['news', 'events', 'stories'];
                        const dataset = datasets[datasetIndex];
                        
                        if (dataset) {
                            window.location.href = `manage_${dataset}.php`;
                        }
                    }
                }
            }
        });

        // Content Distribution Pie Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($content_distribution)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($content_distribution)); ?>,
                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#06b6d4',
                        '#10b981',
                        '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%',
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const element = elements[0];
                        const index = element.index;
                        const pages = ['manage_news.php', 'manage_events.php', 'manage_researchers.php', 'manage_stories.php', 'manage_focus.php'];
                        
                        if (pages[index]) {
                            window.location.href = pages[index];
                        }
                    }
                }
            }
        });

        // Enhanced Dashboard Interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dashboard features
            initializeCounters();
            initializeKeyboardShortcuts();
            initializeRealTimeUpdates();
            
            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Fast animated counters for statistics
        function initializeCounters() {
            const counters = document.querySelectorAll('.stat-card');
            
            const observerOptions = {
                threshold: 0.3,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const card = entry.target;
                        const numberElement = card.querySelector('.stat-number');
                        const target = parseInt(card.getAttribute('data-target'));
                        
                        animateCounter(numberElement, target);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            counters.forEach(counter => {
                observer.observe(counter);
            });
        }

        // Faster counter animation - reduced duration from 2000ms to 800ms
        function animateCounter(element, target) {
            const duration = 800; // Faster animation - was 2000ms
            const frameRate = 60; // 60 FPS for smooth animation
            const totalFrames = Math.round(duration / (1000 / frameRate));
            const increment = target / totalFrames;
            let current = 0;
            let frame = 0;
            
            function updateCounter() {
                frame++;
                current = Math.min(increment * frame, target);
                
                if (current < target) {
                    element.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }
            
            requestAnimationFrame(updateCounter);
        }

        // Real-time updates simulation
        function initializeRealTimeUpdates() {
            // Update last refresh time
            updateLastRefreshTime();
            
            // Simulate real-time updates every 30 seconds
            setInterval(() => {
                updateLastRefreshTime();
                // You can add actual AJAX calls here to fetch new data
            }, 30000);
        }

        function updateLastRefreshTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            
            // Add a small indicator for last update
            let indicator = document.querySelector('.last-update-indicator');
            if (!indicator) {
                indicator = document.createElement('small');
                indicator.className = 'last-update-indicator text-muted';
                indicator.style.position = 'fixed';
                indicator.style.bottom = '90px';
                indicator.style.right = '20px';
                indicator.style.background = 'rgba(255,255,255,0.9)';
                indicator.style.padding = '5px 10px';
                indicator.style.borderRadius = '15px';
                indicator.style.fontSize = '11px';
                indicator.style.zIndex = '1000';
                indicator.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                document.body.appendChild(indicator);
            }
            
            indicator.textContent = `Last updated: ${timeString}`;
            
            // Fade effect
            indicator.style.opacity = '1';
            setTimeout(() => {
                indicator.style.opacity = '0.7';
            }, 2000);
        }

        // Keyboard shortcuts for admin efficiency
        function initializeKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Alt + N = Go to News
                if (e.altKey && e.key === 'n') {
                    e.preventDefault();
                    window.location.href = 'manage_news.php';
                }
                
                // Alt + E = Go to Events
                if (e.altKey && e.key === 'e') {
                    e.preventDefault();
                    window.location.href = 'manage_events.php';
                }
                
                // Alt + R = Go to Researchers
                if (e.altKey && e.key === 'r') {
                    e.preventDefault();
                    window.location.href = 'manage_researchers.php';
                }
                
                // Alt + S = Go to Stories
                if (e.altKey && e.key === 's') {
                    e.preventDefault();
                    window.location.href = 'manage_stories.php';
                }
                
                // Alt + F = Go to Focus Areas
                if (e.altKey && e.key === 'f') {
                    e.preventDefault();
                    window.location.href = 'manage_focus.php';
                }
                
                // Alt + D = Go to Dashboard
                if (e.altKey && e.key === 'd') {
                    e.preventDefault();
                    window.location.href = 'dashboard.php';
                }
                
                // Escape = Close any open modals or dropdowns
                if (e.key === 'Escape') {
                    const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                    openDropdowns.forEach(dropdown => {
                        dropdown.classList.remove('show');
                    });
                }
            });
            
            // Add keyboard shortcut hints
            addKeyboardShortcutHints();
        }

        function addKeyboardShortcutHints() {
            const shortcuts = [
                { key: 'Alt + N', action: 'News Management' },
                { key: 'Alt + E', action: 'Events Management' },
                { key: 'Alt + R', action: 'Researchers Management' },
                { key: 'Alt + S', action: 'Stories Management' },
                { key: 'Alt + F', action: 'Focus Areas Management' },
                { key: 'Alt + D', action: 'Dashboard' }
            ];
            
            // Create shortcuts help button
            const helpButton = document.createElement('button');
            helpButton.className = 'btn btn-sm btn-outline-secondary position-fixed';
            helpButton.style.bottom = '20px';
            helpButton.style.left = '20px';
            helpButton.style.zIndex = '1000';
            helpButton.innerHTML = '<i class="fas fa-keyboard"></i>';
            helpButton.title = 'Keyboard Shortcuts (Click to view)';
            
            helpButton.addEventListener('click', function() {
                showKeyboardShortcuts(shortcuts);
            });
            
            document.body.appendChild(helpButton);
        }

        function showKeyboardShortcuts(shortcuts) {
            // Create modal for shortcuts
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-keyboard me-2"></i>
                                Keyboard Shortcuts
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="list-group">
                                ${shortcuts.map(shortcut => `
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>${shortcut.action}</span>
                                        <kbd class="bg-light text-dark border px-2 py-1 rounded">${shortcut.key}</kbd>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="mt-3 text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Press these key combinations to quickly navigate between sections.
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            
            // Remove modal after hiding
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        }

        // Export functionality
        function addExportFeatures() {
            const exportButton = document.createElement('button');
            exportButton.className = 'btn btn-outline-primary btn-sm position-fixed';
            exportButton.style.bottom = '70px';
            exportButton.style.left = '20px';
            exportButton.style.zIndex = '1000';
            exportButton.innerHTML = '<i class="fas fa-download"></i>';
            exportButton.title = 'Export Dashboard Data';
            
            exportButton.addEventListener('click', function() {
                exportDashboardData();
            });
            
            document.body.appendChild(exportButton);
        }

        function exportDashboardData() {
            // Collect dashboard data
            const data = {
                timestamp: new Date().toISOString(),
                statistics: {},
                monthly_trends: <?php echo json_encode($monthly_data); ?>,
                content_distribution: <?php echo json_encode($content_distribution); ?>
            };
            
            // Collect statistics
            document.querySelectorAll('.stat-card').forEach(card => {
                const label = card.querySelector('.stat-label').textContent;
                const target = card.getAttribute('data-target');
                data.statistics[label] = parseInt(target);
            });
            
            // Create and download JSON file
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `drought-watch-dashboard-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize all enhancements after charts are loaded
        setTimeout(() => {
            addExportFeatures();
        }, 1000);

        // Add click handlers to stat cards for navigation
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('click', function() {
                const label = this.querySelector('.stat-label').textContent.toLowerCase();
                
                if (label.includes('news')) {
                    window.location.href = 'manage_news.php';
                } else if (label.includes('events')) {
                    window.location.href = 'manage_events.php';
                } else if (label.includes('researchers')) {
                    window.location.href = 'manage_researchers.php';
                } else if (label.includes('stories')) {
                    window.location.href = 'manage_stories.php';
                } else if (label.includes('focus')) {
                    window.location.href = 'manage_focus.php';
                }
            });
        });
    </script>
</body>
</html>