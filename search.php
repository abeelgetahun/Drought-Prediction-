<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Drought Prediction System</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand site-title" href="index.php">DroughtWatch</a>

                <div class="mx-auto d-none d-lg-block">
                    <ul class="nav page-indicators">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="researchers.php">Research</a></li>
                        <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="stories.php">Stories</a></li>
                    </ul>
                </div>

                <div class="d-flex align-items-center site-icons">
                    <a href="#" id="search-icon" class="nav-icon p-2"><i class="fas fa-search"></i></a>
                    <a href="#" id="night-mode-toggle" class="nav-icon p-2"><i class="fas fa-moon"></i></a>
                    <div class="dropdown hamburger-menu">
                        <a href="#" id="hamburger-icon" class="nav-icon p-2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="hamburger-icon">
                            <li class="d-lg-none"><a class="dropdown-item" href="index.php">Home</a></li>
                            <li class="d-lg-none"><a class="dropdown-item" href="researchers.php">Research</a></li>
                            <li class="d-lg-none"><a class="dropdown-item" href="news.php">News</a></li>
                            <li class="d-lg-none"><a class="dropdown-item" href="events.php">Events</a></li>
                            <li class="d-lg-none"><a class="dropdown-item" href="stories.php">Stories</a></li>
                            <li><hr class="dropdown-divider d-lg-none"></li>
                            <li><a class="dropdown-item" href="about.php">About Us</a></li>
                            <li><a class="dropdown-item" href="thematic_focus.php">Thematic Focus</a></li>
                            <li><a class="dropdown-item" href="contact.php">Contact Us</a></li>
                            <li><a class="dropdown-item" href="admin/login.php">Admin Login</a></li>
                            <li><a class="dropdown-item" href="#">Support Focus (Placeholder)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mb-5" style="padding-top: 2rem;"> {/* Consistent padding */}
        <h1 class="my-4">Search Results</h1>

        <?php
        $search_query = "";
        $results_found = false;

        if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
            $search_query = trim($_GET['query']);
            $search_param = "%" . $search_query . "%";

            echo "<h4>Results for: \"" . htmlspecialchars($search_query) . "\"</h4><hr>";

            // Search News
            $sql_news = "SELECT id, title, content, publish_date FROM news WHERE title LIKE ? OR content LIKE ? ORDER BY publish_date DESC";
            if ($stmt_news = $mysqli->prepare($sql_news)) {
                $stmt_news->bind_param("ss", $search_param, $search_param);
                $stmt_news->execute();
                $result_news = $stmt_news->get_result();
                if ($result_news->num_rows > 0) {
                    $results_found = true;
                    echo "<h5>News Articles:</h5><ul class='list-group mb-4'>";
                    while ($row = $result_news->fetch_assoc()) {
                        echo "<li class='list-group-item'><a href='news.php#news-" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a><br><small class='text-muted'>" . htmlspecialchars(mb_substr(strip_tags($row['content']), 0, 150)) . "...</small></li>";
                    }
                    echo "</ul>";
                }
                $stmt_news->close();
            }

            // Search Events
            $sql_events = "SELECT id, name, description, event_date FROM events WHERE name LIKE ? OR description LIKE ? ORDER BY event_date DESC";
            if ($stmt_events = $mysqli->prepare($sql_events)) {
                $stmt_events->bind_param("ss", $search_param, $search_param);
                $stmt_events->execute();
                $result_events = $stmt_events->get_result();
                if ($result_events->num_rows > 0) {
                    $results_found = true;
                    echo "<h5>Events:</h5><ul class='list-group mb-4'>";
                    while ($row = $result_events->fetch_assoc()) {
                        echo "<li class='list-group-item'><a href='events.php#event-" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a> (" . date('F j, Y', strtotime($row['event_date'])) . ")<br><small class='text-muted'>" . htmlspecialchars(mb_substr(strip_tags($row['description']), 0, 150)) . "...</small></li>";
                    }
                    echo "</ul>";
                }
                $stmt_events->close();
            }
            
            // Search Researchers
            $sql_researchers = "SELECT id, name, bio, research_focus FROM researchers WHERE name LIKE ? OR bio LIKE ? OR research_focus LIKE ?";
            if ($stmt_researchers = $mysqli->prepare($sql_researchers)) {
                $stmt_researchers->bind_param("sss", $search_param, $search_param, $search_param);
                $stmt_researchers->execute();
                $result_researchers = $stmt_researchers->get_result();
                if ($result_researchers->num_rows > 0) {
                    $results_found = true;
                    echo "<h5>Researchers:</h5><ul class='list-group mb-4'>";
                    while ($row = $result_researchers->fetch_assoc()) {
                        echo "<li class='list-group-item'><a href='researchers.php#researcher-" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a> - " . htmlspecialchars($row['research_focus']) ."</li>";
                    }
                    echo "</ul>";
                }
                $stmt_researchers->close();
            }

            // Search Stories
            $sql_stories = "SELECT id, title, narrative, author FROM stories WHERE title LIKE ? OR narrative LIKE ? OR author LIKE ?";
            if ($stmt_stories = $mysqli->prepare($sql_stories)) {
                $stmt_stories->bind_param("sss", $search_param, $search_param, $search_param);
                $stmt_stories->execute();
                $result_stories = $stmt_stories->get_result();
                if ($result_stories->num_rows > 0) {
                    $results_found = true;
                    echo "<h5>Stories:</h5><ul class='list-group mb-4'>";
                    while ($row = $result_stories->fetch_assoc()) {
                        echo "<li class='list-group-item'><a href='stories.php#story-" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a> by " . htmlspecialchars($row['author']) ."</li>";
                    }
                    echo "</ul>";
                }
                $stmt_stories->close();
            }

            // Search Focus Areas
            $sql_focus = "SELECT id, name, description FROM focus WHERE name LIKE ? OR description LIKE ?";
            if ($stmt_focus = $mysqli->prepare($sql_focus)) {
                $stmt_focus->bind_param("ss", $search_param, $search_param);
                $stmt_focus->execute();
                $result_focus = $stmt_focus->get_result();
                if ($result_focus->num_rows > 0) {
                    $results_found = true;
                    echo "<h5>Thematic Focus Areas:</h5><ul class='list-group mb-4'>";
                    while ($row = $result_focus->fetch_assoc()) {
                        echo "<li class='list-group-item'><a href='thematic_focus.php#focus-" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a></li>";
                    }
                    echo "</ul>";
                }
                $stmt_focus->close();
            }


            if (!$results_found) {
                echo "<p>No results found matching your query.</p>";
            }

        } else {
            echo "<p>Please enter a search term in the navigation bar.</p>";
        }
        $mysqli->close();
        ?>
    </main>

    <footer class="site-footer mt-auto py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h5>About DroughtWatch</h5>
                    <p class="text-muted small">DroughtWatch is dedicated to providing timely and accurate information on drought conditions, leveraging research and data analysis to support communities and decision-makers.</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="privacy.php" class="footer-link">Privacy Policy</a></li>
                        <li><a href="terms.php" class="footer-link">Terms of Use</a></li>
                        <li><a href="contact.php" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Connect With Us</h5>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col text-center text-muted small">
                    &copy; <?php echo date("Y"); ?> DroughtWatch. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
