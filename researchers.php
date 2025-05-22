<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drought Prediction System - Researchers</title>
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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="researchers.php">Researchers</a></li>
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
    <main class="container mt-5 pt-4 mb-5">
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
                            <?php if (!empty($row['photo_url'])): ?>
                                <img src="<?php echo htmlspecialchars($row['photo_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>" style="height: 250px; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x250.png?text=No+Image" class="card-img-top" alt="Placeholder image for <?php echo htmlspecialchars($row['name']); ?>" style="height: 250px; object-fit: cover;">
                            <?php endif; ?>
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
    <footer class="bg-dark text-white text-center p-3 mt-auto footer">
        <p>&copy; <?php echo date("Y"); ?> Drought Prediction System</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
