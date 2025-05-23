<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DroughtWatch - Researchers</title>
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
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" href="researchers.php">Research</a></li>
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
                            <li class="d-lg-none"><a class="dropdown-item active" href="researchers.php">Research</a></li>
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
        <h1 class="my-4">Our Researchers</h1>
        <section class="row">
            <?php
            $sql = "SELECT id, name, bio, photo_url, research_focus FROM researchers ORDER BY name ASC";
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-6 col-lg-4 mb-4" id="researcher-<?php echo $row['id']; ?>">
                        <div class="card h-100">
                            <div class="image-loader-wrapper" style="height: 250px; background-color: #e9ecef;">
                                <?php if (!empty($row['photo_url'])): ?>
                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
                                         data-src="<?php echo htmlspecialchars($row['photo_url']); ?>" 
                                         class="card-img-top lazy-load-image" 
                                         alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                         style="height: 250px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x250.png?text=No+Photo" 
                                         class="card-img-top" 
                                         alt="Placeholder image for <?php echo htmlspecialchars($row['name']); ?>" 
                                         style="height: 250px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><strong>Focus:</strong> <?php echo htmlspecialchars($row['research_focus']); ?></p>
                                <p class="card-text">
                                    <?php 
                                    $bio_snippet = mb_substr(strip_tags($row['bio']), 0, 150);
                                    echo nl2br(htmlspecialchars($bio_snippet)) . (mb_strlen($row['bio']) > 150 ? '...' : ''); 
                                    ?>
                                </p>
                                <!-- Optionally, a link to a more detailed researcher page if it exists -->
                                <!-- <a href="researcher_profile.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary mt-auto">Read More</a> -->
                            </div>
                        </div>
                    </div>
            <?php
                }
                $result->free();
            } else {
                echo "<p class='col-12'>No researcher profiles found.</p>";
            }
            // $mysqli->close(); 
            ?>
        </section>
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
    <script src="js/image-loader.js"></script>
</body>
</html>
