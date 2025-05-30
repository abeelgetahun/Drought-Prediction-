<?php require_once '../config/db.php'; // Include if any DB interaction is needed, or for consistency ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DroughtWatch - Terms of Use</title>
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
        <div class="row">
            <div class="col-12">
                <h1 class="my-4">Terms of Use</h1>
                <p>Content for the Terms of Use page is coming soon.</p>
                <p>Please check back later.</p>
            </div>
        </div>
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
    <script src="js/main.js"></script>
    <script src="js/image-loader.js"></script> 
</body>
</html>
