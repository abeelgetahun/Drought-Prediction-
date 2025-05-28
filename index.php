<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DroughtWatch - Homepage</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand site-title" href="index.php">DroughtWatch</a>
                <div class="mx-auto d-none d-lg-block">
                    <ul class="nav page-indicators">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
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

    <div class="news-ticker-container fixed-top-ticker">
        <span class="ticker-label">Latest News:</span>
        <div class="ticker-content">
            <ul id="news-ticker-list">
                <?php
                $sql_ticker_news = "SELECT id, title FROM news ORDER BY publish_date DESC LIMIT 7";
                $result_ticker_news = $mysqli->query($sql_ticker_news);
                if ($result_ticker_news && $result_ticker_news->num_rows > 0) {
                    while ($ticker_item = $result_ticker_news->fetch_assoc()) {
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

    <main class="container-fluid p-0" style="padding-top: 111px;"> {/* Approx 66px for navbar + 45px for ticker */}
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
                $sql_banner_news = "SELECT id, title, content, image_url FROM news WHERE image_url IS NOT NULL AND image_url != '' ORDER BY publish_date DESC LIMIT 3";
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
                                <a href="news.php#news-<?php echo $news_item['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
                            </div>
                        </div>
                <?php
                        $slide_count++;
                    }
                    $result_banner_news->free();
                } else {
                    echo '<div class="carousel-item active" style="height: 400px; background-color: #777;">'; // Fallback if no news with images
                    echo '<div class="carousel-caption d-none d-md-block">';
                    echo '<h5>Welcome to DroughtWatch</h5>';
                    echo '<p>Monitoring and predicting drought conditions.</p>';
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

        <section class="container my-5 intro-section text-center">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <i class="fas fa-tint fa-3x mb-3 text-primary"></i> {/* Example Icon */}
                    <h2 class="mb-3 section-title">Welcome to DroughtWatch</h2>
                    <p class="lead mb-4">
                        Your comprehensive resource for understanding, monitoring, and predicting drought conditions. 
                        We leverage real-time data, advanced analytics, and cutting-edge research to provide timely insights 
                        for communities, agriculture, and policymakers.
                    </p>
                    <p>
                        Explore our platform to access the latest news, research findings, upcoming events, and community stories related to drought. 
                        Together, we can build resilience and mitigate the impacts of drought.
                    </p>
                </div>
            </div>
        </section>

        <section class="container my-5 research-highlights">
            <h3 class="text-center mb-4 section-title">Recent Research & News</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="research-grid">
                <?php
                $sql_research = "SELECT id, title, content, image_url, publish_date FROM news ORDER BY publish_date DESC LIMIT 6"; // Fetch 6 items for a 2x3 or 3x2 grid
                $result_research = $mysqli->query($sql_research);
                if ($result_research && $result_research->num_rows > 0) {
                    while ($item = $result_research->fetch_assoc()) {
                        $image_path_or_url = !empty($item['image_url']) ? htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/400x300.png?text=Research+Highlight'; // Placeholder if no image
                        $alt_text = !empty($item['image_url']) ? htmlspecialchars($item['title']) : 'Placeholder image for research highlight';
                ?>
                        <div class="col research-card">
                            <div class="card h-100 shadow-sm">
                                <div class="image-loader-wrapper" style="height: 200px; background-color: #e9ecef;">
                                     <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
                                         data-src="<?php echo $image_path_or_url; ?>" 
                                         class="card-img-top lazy-load-image" 
                                         alt="<?php echo $alt_text; ?>" 
                                         style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="far fa-calendar-alt me-1"></i><?php echo date("F j, Y", strtotime($item['publish_date'])); ?>
                                    </p>
                                    <p class="card-text summary flex-grow-1"><?php echo htmlspecialchars(mb_substr(strip_tags($item['content']), 0, 120)); ?>...</p>
                                    <a href="news.php#news-<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary align-self-start mt-auto">Read More <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    $result_research->free();
                } else {
                    echo '<p class="col-12 text-center">No recent research highlights found.</p>';
                }
                ?>
            </div>
        </section>

        <div class="container mt-5 pt-3 mb-5"> {/* Old Key Focus Areas section - can be removed or kept */}
            <h2 class="mb-3 text-center section-title">Key Focus Areas</h2>
            <div class="row">
                <?php
                $sql_focus_sample = "SELECT id, name, description FROM focus ORDER BY RAND() LIMIT 3"; 
                if($result_focus_sample = $mysqli->query($sql_focus_sample)){
                    while($focus_item = $result_focus_sample->fetch_assoc()){
                ?>
                    <div class="col-md-4 mb-3 research-card"> {/* Added research-card for animation */}
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <i class="fas fa-bullseye fa-2x mb-3 text-primary"></i> {/* Example icon */}
                                <h5 class="card-title"><?php echo htmlspecialchars($focus_item['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars(mb_substr(strip_tags($focus_item['description']),0,100)); ?>...</p>
                                <a href="thematic_focus.php#focus-<?php echo $focus_item['id']; ?>" class="btn btn-sm btn-accent-olive">Learn More</a>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                    $result_focus_sample->free();
                } else {
                    echo "<p class='col-12 text-center'>Focus areas will be highlighted here.</p>";
                }
                ?>
            </div>
        </section>
        <?php $mysqli->close(); ?>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <script src="js/image-loader.js"></script>
</body>
</html>
