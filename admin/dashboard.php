<?php
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Include the database configuration
require_once '../config/db.php';

// You can fetch more user details from the database if needed
// For example, if you stored the user's full name or role

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Drought Prediction System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5"> {/* Adjusted pt-5 and added mb-5 for footer */}
        <h1 class="mt-4">Admin Dashboard</h1>
        <p>Welcome to the admin area. From here you can manage the website content.</p>
        
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage News</h5>
                        <p class="card-text">Create, edit, and delete news articles.</p>
                        <a href="manage_news.php" class="btn btn-primary">Go to News</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Events</h5>
                        <p class="card-text">Add, update, and remove event listings.</p>
                        <a href="manage_events.php" class="btn btn-primary">Go to Events</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Researchers</h5>
                        <p class="card-text">Update researcher profiles and information.</p>
                        <a href="manage_researchers.php" class="btn btn-primary">Go to Researchers</a>
                    </div>
                </div>
            </div>
            <!-- Add more cards for other sections as needed -->
             <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Stories</h5>
                        <p class="card-text">Curate and update user stories.</p>
                        <a href="manage_stories.php" class="btn btn-primary">Go to Stories</a>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Focus Areas</h5>
                        <p class="card-text">Define and edit thematic focus categories.</p>
                        <a href="manage_focus.php" class="btn btn-primary">Go to Focus Areas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
