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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Drought Prediction System</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #3498db;
        }
        
        body {
            background-color: #f5f8fa;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-bottom: 70px;
        }
        
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            border-radius: 4px;
            margin: 0 5px;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white !important;
            background-color: rgba(255,255,255,0.1);
        }
        
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        
        .stat-card .icon {
            font-size: 36px;
            margin-right: 15px;
            background: rgba(255,255,255,0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-card .details .number {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .stat-card .details .title {
            font-size: 14px;
            opacity: 0.8;
        }
        
        .news-card {
            background-color: var(--primary-color);
            color: white;
        }
        
        .events-card {
            background-color: var(--warning-color);
        }
        
        .researchers-card {
            background-color: var(--info-color);
        }
        
        .stories-card {
            background-color: var(--success-color);
        }
        
        .focus-card {
            background-color: var(--accent-color);
        }
        
        .activity-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s;
        }
        
        .activity-item:hover {
            background-color: #f9f9f9;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .section-heading {
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--dark-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="section-heading"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h1>
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

        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="stat-card news-card">
                    <div class="icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="details">
                        <p class="number"><?php echo $stats['news']; ?></p>
                        <p class="title">News Articles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="stat-card events-card">
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="details">
                        <p class="number"><?php echo $stats['events']; ?></p>
                        <p class="title">Events</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="stat-card researchers-card">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="details">
                        <p class="number"><?php echo $stats['researchers']; ?></p>
                        <p class="title">Researchers</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="stat-card stories-card">
                    <div class="icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="details">
                        <p class="number"><?php echo $stats['stories']; ?></p>
                        <p class="title">Stories</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="stat-card focus-card">
                    <div class="icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="details">
                        <p class="number"><?php echo $stats['focus']; ?></p>
                        <p class="title">Focus Areas</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card dashboard-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-rss me-2"></i> Recent News
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($recent_news)): ?>
                            <div class="p-4 text-center text-muted">
                                <i class="fas fa-newspaper fa-3x mb-3"></i>
                                <p>No recent news found.</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_news as $news): ?>
                                    <div class="activity-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($news['title']); ?></h6>
                                            <small><?php echo date('M d, Y', strtotime($news['publish_date'])); ?></small>
                                        </div>
                                        <a href="edit_news.php?id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-end">
                        <a href="manage_news.php" class="btn btn-sm btn-primary">View All News</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card dashboard-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-calendar me-2"></i> Upcoming Events
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($upcoming_events)): ?>
                            <div class="p-4 text-center text-muted">
                                <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                <p>No upcoming events found.</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($upcoming_events as $event): ?>
                                    <div class="activity-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><?php echo htmlspecialchars($event['name']); ?></h6>
                                            <small><?php echo date('M d, Y', strtotime($event['event_date'])); ?></small>
                                        </div>
                                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-end">
                        <a href="manage_events.php" class="btn btn-sm btn-primary">View All Events</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h2 class="section-heading"><i class="fas fa-toolbox me-2"></i>Quick Access</h2>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="py-3">
                            <i class="fas fa-newspaper fa-4x text-primary mb-3"></i>
                            <h5 class="card-title">Manage News</h5>
                            <p class="card-text">Create, edit, and delete news articles.</p>
                        </div>
                        <a href="manage_news.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-1"></i> Go to News
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="py-3">
                            <i class="fas fa-calendar-alt fa-4x text-warning mb-3"></i>
                            <h5 class="card-title">Manage Events</h5>
                            <p class="card-text">Add, update, and remove event listings.</p>
                        </div>
                        <a href="manage_events.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-1"></i> Go to Events
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="py-3">
                            <i class="fas fa-users fa-4x text-info mb-3"></i>
                            <h5 class="card-title">Manage Researchers</h5>
                            <p class="card-text">Update researcher profiles and information.</p>
                        </div>
                        <a href="manage_researchers.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-1"></i> Go to Researchers
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="py-3">
                            <i class="fas fa-book-open fa-4x text-success mb-3"></i>
                            <h5 class="card-title">Manage Stories</h5>
                            <p class="card-text">Curate and update user stories.</p>
                        </div>
                        <a href="manage_stories.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-1"></i> Go to Stories
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center">
                        <div class="py-3">
                            <i class="fas fa-bullseye fa-4x text-danger mb-3"></i>
                            <h5 class="card-title">Manage Focus Areas</h5>
                            <p class="card-text">Define and edit thematic focus categories.</p>
                        </div>
                        <a href="manage_focus.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-1"></i> Go to Focus Areas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>