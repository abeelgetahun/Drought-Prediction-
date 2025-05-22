<?php require_once 'config/db.php'; // For potential future use, not strictly needed for static form display ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drought Prediction System - Contact Us</title>
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
                        <li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="thematic_focus.php">Thematic Focus</a></li>
                        <li class="nav-item"><a class="nav-link" href="stories.php">Stories</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a></li>
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
        <h1 class="my-4">Contact Us</h1>
        <p>Have questions, suggestions, or want to collaborate? Reach out to us using the form below or through the contact details provided.</p>
        
        <div class="row">
            <div class="col-md-8">
                <h3 class="mb-3">Send us a Message</h3>
                <form action="contact.php" method="POST"> <?php // Action can be blank or point to a processing script ?>
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="contactName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="contactEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="contactSubject" name="subject">
                    </div>
                    <div class="mb-3">
                        <label for="contactMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="contactMessage" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                    <?php 
                    // Placeholder for submission feedback
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Basic non-functional feedback for MVP
                        echo '<div class="alert alert-success mt-3">Thank you for your message! (This is a demo - no email has been sent.)</div>';
                    }
                    ?>
                </form>
            </div>
            <div class="col-md-4">
                <h3 class="mb-3">Our Contact Information</h3>
                <p>
                    <strong>Email:</strong> <a href="mailto:info@droughtprediction.org">info@droughtprediction.org</a><br>
                    <strong>Phone:</strong> +1 (555) 123-4567<br>
                    <strong>Address:</strong> 123 Research Park, Science City, SC 90210
                </p>
                <p>Follow us on social media (links are placeholders):</p>
                <p>
                    <a href="#" class="btn btn-outline-primary btn-sm mb-1">Twitter</a>
                    <a href="#" class="btn btn-outline-primary btn-sm mb-1">LinkedIn</a>
                    <a href="#" class="btn btn-outline-primary btn-sm mb-1">Facebook</a>
                </p>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white text-center p-3 mt-auto footer">
        <p>&copy; <?php echo date("Y"); ?> Drought Prediction System</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="js/main.js"></script> <?php // In case any global JS is needed, good to keep it ?>
</body>
</html>
