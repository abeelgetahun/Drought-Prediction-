<?php 
require_once 'config/db.php';
$pageTitle = "DroughtWatch - Monitor Drought Conditions";
$pageDescription = "DroughtWatch provides real-time monitoring and analysis of drought conditions through advanced data visualization and research.";
$basePath = '';
$cssPath = '';
include 'includes/header.php';
?>

<!-- Hero Welcome Section -->
<section class="hero-welcome">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">
                        hi. this is<br>
                        <span style="color: var(--current-accent);">droughtwatch.</span>
                    </h1>
                    <p class="hero-subtitle">
                        we built a comprehensive platform for<br>
                        monitoring and predicting drought conditions —<br>
                        to analyze, understand and share insights with the world.
                    </p>
                    <div class="hero-cta">
                        <a href="pages/about.php" class="btn btn-primary">
                            Explore Our Mission
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="pages/researchers.php" class="btn btn-outline">
                            View Research
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="geometric-shapes">
                        <div class="shape shape-1" style="--rotation: 15deg;"></div>
                        <div class="shape shape-2" style="--rotation: -10deg;"></div>
                        <div class="shape shape-3" style="--rotation: 25deg;"></div>
                        <div class="shape shape-4" style="--rotation: -20deg;"></div>
                        <div class="shape shape-5" style="--rotation: 5deg;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Data Visualization Section -->
<section class="content-section">
    <div class="container">
        <h2 class="section-title">Real-Time Drought Monitoring</h2>
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3>Advanced Analytics Dashboard</h3>
                <p class="lead">
                    DroughtWatch leverages satellite imagery, weather station data, and machine learning 
                    to provide real-time drought conditions and predictions.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-chart-line me-2" style="color: var(--current-accent);"></i> Precipitation anomalies</li>
                    <li class="mb-2"><i class="fas fa-leaf me-2" style="color: var(--current-accent);"></i> Vegetation health indices</li>
                    <li class="mb-2"><i class="fas fa-temperature-high me-2" style="color: var(--current-accent);"></i> Temperature patterns</li>
                    <li class="mb-2"><i class="fas fa-water me-2" style="color: var(--current-accent);"></i> Soil moisture analysis</li>
                </ul>
                <a href="#" class="btn btn-primary">View Dashboard</a>
            </div>
            <div class="col-lg-6">
                <div class="dashboard-preview p-4" style="background: linear-gradient(135deg, var(--current-bg-secondary) 0%, var(--current-bg-tertiary) 100%); border-radius: 15px;">
                    <div style="height: 300px; background: linear-gradient(135deg, var(--current-accent) 0%, rgba(255,215,0,0.1) 100%); border-radius: 10px; position: relative; overflow: hidden;">
                        <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 60%; background: linear-gradient(to top, rgba(0,0,0,0.3), transparent); clip-path: polygon(0 100%, 15% 85%, 30% 90%, 45% 75%, 60% 80%, 75% 65%, 90% 70%, 100% 60%, 100% 100%);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Research & News Section -->
<section class="content-section">
    <div class="container">
        <h2 class="section-title">Latest Research & News</h2>
        <div class="row g-4">
            <?php
            $sql_research = "SELECT id, title, content, image_url, publish_date FROM news ORDER BY publish_date DESC LIMIT 6";
            $result_research = $mysqli->query($sql_research);
            if ($result_research && $result_research->num_rows > 0) {
                while ($item = $result_research->fetch_assoc()) {
                    $image_path_or_url = !empty($item['image_url']) ? htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/400x250/f8f9fa/6c757d?text=Research+Highlight';
            ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <img src="<?php echo $image_path_or_url; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <p class="text-muted small mb-2">
                                    <i class="far fa-calendar me-1"></i>
                                    <?php echo date("F j, Y", strtotime($item['publish_date'])); ?>
                                </p>
                                <p class="card-text flex-grow-1">
                                    <?php echo htmlspecialchars(mb_substr(strip_tags($item['content']), 0, 120)); ?>...
                                </p>
                                <a href="pages/news.php#news-<?php echo $item['id']; ?>" class="btn btn-outline-dark btn-sm mt-auto">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
                $result_research->free();
            } else {
                echo '<div class="col-12 text-center"><p>No recent research highlights found.</p></div>';
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="pages/news.php" class="btn btn-primary">View All News</a>
        </div>
    </div>
</section>

<!-- Key Focus Areas -->
<section class="content-section">
    <div class="container">
        <h2 class="section-title">Key Focus Areas</h2>
        <div class="row g-4">
            <?php
            $sql_focus = "SELECT id, name, description FROM focus ORDER BY RAND() LIMIT 3";
            if($result_focus = $mysqli->query($sql_focus)){
                while($focus_item = $result_focus->fetch_assoc()){
            ?>
                    <div class="col-md-4">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="fas fa-bullseye fa-3x" style="color: var(--current-accent);"></i>
                                </div>
                                <h5 class="card-title"><?php echo htmlspecialchars($focus_item['name']); ?></h5>
                                <p class="card-text">
                                    <?php echo htmlspecialchars(mb_substr(strip_tags($focus_item['description']), 0, 100)); ?>...
                                </p>
                                <a href="pages/thematic_focus.php#focus-<?php echo $focus_item['id']; ?>" class="btn btn-primary">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
                $result_focus->free();
            } else {
                echo '<div class="col-12 text-center"><p>Focus areas will be highlighted here.</p></div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="hero-welcome" style="min-height: 60vh;">
    <div class="container text-center">
        <h2 class="hero-title" style="font-size: clamp(2rem, 5vw, 3.5rem);">
            Join Our <span style="color: var(--current-accent);">Network</span>
        </h2>
        <p class="hero-subtitle">
            Connect with researchers, policymakers, and community leaders<br>
            to build drought resilience together.
        </p>
        <div class="hero-cta justify-content-center">
            <a href="pages/contact.php" class="btn btn-primary btn-lg">
                Get Involved
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>