<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drought Prediction System - Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="researchers.php">Researchers</a></li>
                        <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="thematic_focus.php">Thematic Focus</a></li>
                        <li class="nav-item"><a class="nav-link" href="stories.php">Stories</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    </ul>
                    <form class="d-flex" action="search.php" method="GET">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <div class="news-ticker-container fixed-top-ticker">
        <span class="ticker-label">Latest News:</span>
        <div class="ticker-content">
            <ul id="news-ticker-list">
                <?php
                $sql_ticker_news = "SELECT id, title FROM news ORDER BY publish_date DESC LIMIT 7";
                $result_ticker_news = $mysqli->query($sql_ticker_news);
                if ($result_ticker_news && $result_ticker_news->num_rows > 0) {
                    while ($ticker_item = $result_ticker_news->fetch_assoc()) {
                        // Assuming news.php will scroll to the article or a future single_news.php
                        echo '<li><a href="news.php#news-' . $ticker_item['id'] . '">' . htmlspecialchars($ticker_item['title']) . '</a></li>';
                    }
                    $result_ticker_news->free();
                } else {
                    echo '<li>No recent news.</li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <main class="container-fluid p-0" style="padding-top: 101px;"> {/* 56px for navbar + approx 45px for ticker */}
        <div id="homepage-banner" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                $sql_banner_news_count = "SELECT COUNT(*) as total FROM news WHERE image_url IS NOT NULL AND image_url != '' ORDER BY publish_date DESC LIMIT 3";
                $result_banner_news_count = $mysqli->query($sql_banner_news_count);
                $total_slides = 0;
                if($result_banner_news_count && $result_banner_news_count->num_rows > 0){
                    $total_slides = $result_banner_news_count->fetch_assoc()['total'];
                }
                for ($i = 0; $i < $total_slides; $i++) {
                    echo '<button type="button" data-bs-target="#homepage-banner" data-bs-slide-to="' . $i . '" class="' . ($i == 0 ? 'active' : '') . '" aria-current="' . ($i == 0 ? 'true' : 'false') . '" aria-label="Slide ' . ($i + 1) . '"></button>';
                }
                ?>
            </div>
            <div class="carousel-inner">
                <?php
                $sql_banner_news = "SELECT title, content, image_url FROM news WHERE image_url IS NOT NULL AND image_url != '' ORDER BY publish_date DESC LIMIT 3";
                $result_banner_news = $mysqli->query($sql_banner_news);
                $slide_count = 0;
                if ($result_banner_news && $result_banner_news->num_rows > 0) {
                    while ($news_item = $result_banner_news->fetch_assoc()) {
                ?>
                        <div class="carousel-item <?php echo ($slide_count == 0) ? 'active' : ''; ?>" style="height: 400px; background-color: #e9ecef;">
                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
                                 data-src="<?php echo htmlspecialchars($news_item['image_url']); ?>" 
                                 class="d-block w-100 lazy-load-image" 
                                 alt="<?php echo htmlspecialchars($news_item['title']); ?>" 
                                 style="height: 400px; object-fit: cover;">
                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                                <h5><?php echo htmlspecialchars($news_item['title']); ?></h5>
                                <p><?php echo htmlspecialchars(mb_substr(strip_tags($news_item['content']), 0, 100)); ?>...</p>
                                <!-- <a href="news.php#news-<?php echo $news_item['id']; ?>" class="btn btn-primary btn-sm">Read More</a> -->
                            </div>
                        </div>
                <?php
                        $slide_count++;
                    }
                    $result_banner_news->free();
                } else {
                    echo '<div class="carousel-item active" style="height: 400px; background-color: #777;">';
                    echo '<div class="carousel-caption d-none d-md-block">';
                    echo '<h5>Welcome to the Drought Prediction System!</h5>';
                    echo '<p>Stay tuned for the latest news and updates.</p>';
                    echo '</div></div>';
                }
                ?>
            </div>
            <?php if ($total_slides > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#homepage-banner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homepage-banner" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <?php endif; ?>
        </div>

        <div class="container mt-5 pt-3 mb-5">
            <h1 class="text-center">Drought Prediction & Analysis</h1>
            <p class="lead text-center">Leveraging data and research to understand and mitigate drought impacts.</p>
            
            <section class="mt-5">
                <h2 class="mb-3">Key Focus Areas</h2>
                <div class="row">
                    <?php
                    $sql_focus_sample = "SELECT name, description FROM focus ORDER BY RAND() LIMIT 3"; // Get 3 random focus areas
                    if($result_focus_sample = $mysqli->query($sql_focus_sample)){
                        while($focus_item = $result_focus_sample->fetch_assoc()){
                    ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($focus_item['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(mb_substr(strip_tags($focus_item['description']),0,120)); ?>...</p>
                                    <a href="thematic_focus.php#heading<?php /* Need ID here, but not available in this query directly, link to page is fine */ ?>" class="btn btn-sm btn-outline-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                        $result_focus_sample->free();
                    } else {
                        echo "<p class='col-12'>Focus areas will be highlighted here.</p>";
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-auto">
        <p>&copy; <?php echo date("Y"); ?> Drought Prediction System</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <script src="js/image-loader.js"></script>
</body>
</html>
