<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drought Prediction System - News</title>
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
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="researchers.php">Researchers</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="news.php">News</a></li>
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
    <main class="container mt-5 pt-4 mb-5">
        <h1 class="my-4">Latest News & Research Updates</h1>
        <section class="row">
            <?php
            $sql = "SELECT id, title, content, image_url, publish_date FROM news ORDER BY publish_date DESC";
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-12 mb-4" id="news-<?php echo $row['id']; ?>">
                        <div class="card">
                            <?php if (!empty($row['image_url'])): ?>
                                <div class="image-loader-wrapper" style="max-height: 300px; background-color: #e9ecef;">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
                                         data-src="<?php echo htmlspecialchars($row['image_url']); ?>" 
                                         class="card-img-top lazy-load-image" 
                                         alt="<?php echo htmlspecialchars($row['title']); ?>" 
                                         style="max-height: 300px; object-fit: cover;">
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><small class="text-muted">Published on <?php echo date('F j, Y, g:i a', strtotime($row['publish_date'])); ?></small></p>
                                <p class="card-text">
                                    <?php 
                                    // Display a snippet or full content. For now, snippet.
                                    $content_snippet = mb_substr(strip_tags($row['content']), 0, 250);
                                    echo nl2br(htmlspecialchars($content_snippet)) . (mb_strlen($row['content']) > 250 ? '...' : ''); 
                                    ?>
                                </p>
                                <!-- Link to a potential single_news.php page if needed, or expand content -->
                                <!-- <a href="single_news.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a> -->
                            </div>
                        </div>
                    </div>
            <?php
                }
                $result->free();
            } else {
                echo "<p class='col-12'>No news articles found.</p>";
            }
            // $mysqli->close(); // Connection should be closed at the end of script execution or if db.php handles it.
            ?>
        </section>
    </main>
    <footer class="bg-dark text-white text-center p-3 mt-auto footer">
        <p>&copy; <?php echo date("Y"); ?> Drought Prediction System</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/image-loader.js"></script>
</body>
</html>
