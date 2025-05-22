<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Drought Prediction System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Drought Prediction</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="researchers.php">Researchers</a></li>
                        <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="thematic_focus.php">Thematic Focus</a></li>
                        <li class="nav-item"><a class="nav-link" href="stories.php">Stories</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    </ul>
                    <form class="d-flex" action="search.php" method="GET">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 pt-4 mb-5">
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

    <footer class="bg-dark text-white text-center p-3 mt-auto footer">
        <p>&copy; <?php echo date("Y"); ?> Drought Prediction System</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
