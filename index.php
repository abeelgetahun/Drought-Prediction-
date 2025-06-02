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
                        hello. this is<br>
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
                        <div class="shape shape-1" style="--rotation: 15deg;">
                            <img src="assets/images/hero/shape1.jpg" alt="Drought Monitoring" class="shape-image">
                        </div>
                        <div class="shape shape-2" style="--rotation: -10deg;">
                            <img src="assets/images/hero/shape2.jpg" alt="Satellite Data" class="shape-image">
                        </div>
                        <div class="shape shape-3" style="--rotation: 25deg;">
                            <img src="assets/images/hero/shape3.jpg" alt="Climate Analysis" class="shape-image">
                        </div>
                        <div class="shape shape-4" style="--rotation: -20deg;">
                            <img src="assets/images/hero/shape4.jpg" alt="Research Data" class="shape-image">
                        </div>
                        <div class="shape shape-5" style="--rotation: 5deg;">
                            <img src="assets/images/hero/shape5.jpg" alt="Global Impact" class="shape-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Data Visualization Section with Parallax Background -->
<section class="parallax-section" id="drought-monitoring">
    <div class="parallax-content">
        <div class="container">
            <div class="section-title-wrapper">
                <h2 class="section-title text-white">Real-Time Drought Monitoring</h2>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="content-card">
                        <div class="content-header">
                            <h3>Advanced Analytics Dashboard</h3>
                            <p>DroughtWatch leverages satellite imagery, weather data, and machine learning for real-time drought monitoring.</p>
                        </div>
                        <ul class="feature-list">
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="feature-text">
                                    <strong>Precipitation anomalies</strong>
                                </div>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div class="feature-text">
                                    <strong>Vegetation health indices</strong>
                                </div>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-temperature-high"></i>
                                </div>
                                <div class="feature-text">
                                    <strong>Temperature patterns</strong>
                                </div>
                            </li>
                            <li>
                                <div class="feature-icon">
                                    <i class="fas fa-water"></i>
                                </div>
                                <div class="feature-text">
                                    <strong>Soil moisture analysis</strong>
                                </div>
                            </li>
                        </ul>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="dashboard-preview">
                        <div class="dashboard-visual">
                            <div class="dashboard-chart"></div>
                            <div class="dashboard-overlay"></div>
                        </div>
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

<style>
/* Additional CSS for Image Shapes */
.shape-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: var(--image-shadow);
    transition: all 0.3s ease;
}

.shape:hover .shape-image {
    transform: scale(1.05);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
}

/* Override the background gradient for shapes when using images */
.shape {
    background: none !important;
    overflow: hidden;
}

/* Add a subtle overlay for better text contrast if needed */
.shape::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent 0%, rgba(0,0,0,0.1) 100%);
    border-radius: 10px;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.shape:hover::after {
    opacity: 1;
}

/* Parallax Section Styles - Optimized for Image Quality */
.parallax-section {
    position: relative;
    min-height: 500px; /* Reduced height */
    background-image: url('assets/images/drought-landscape.jpg');
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
    overflow: hidden;
    /* Removed backdrop-filter to preserve image quality */
}

.parallax-content {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 4rem 0; /* Reduced padding */
    /* Removed background blur to preserve image quality */
}

/* Section title with localized blur */
.section-title-wrapper {
    text-align: center;
    margin-bottom: 2rem; /* Reduced margin */
}

.section-title-wrapper .section-title {
    position: relative;
    display: inline-block;
    padding: 1rem 2rem;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.parallax-section .section-title::after {
    background-color: white;
}

/* Compact content card with localized blur */
.content-card {
    background: transparent; /* Removed black background */
    border-radius: 12px;
    padding: 0; /* Removed padding */
    color: white;
    /* Removed backdrop-filter and borders */
}

.content-header {
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.content-header h3 {
    color: white;
    margin-bottom: 0.75rem;
    font-weight: 600;
    font-size: 1.5rem; /* Reduced font size */
}

.content-header p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 0.95rem; /* Reduced font size */
    line-height: 1.4;
}

/* Compact feature list */
.feature-list {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.feature-list li {
    display: flex;
    align-items: center;
    margin-bottom: 1rem; /* Reduced margin */
    transition: transform 0.3s ease;
}

.feature-list li:last-child {
    margin-bottom: 0;
}

.feature-list li:hover {
    transform: translateX(5px);
}

.feature-icon {
    width: 40px; /* Reduced size */
    height: 40px;
    background: var(--current-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.feature-icon i {
    font-size: 1rem; /* Reduced size */
    color: var(--current-bg);
}

.feature-text strong {
    font-size: 1rem; /* Reduced size */
    color: white;
}

/* CTA wrapper with localized blur */
.cta-wrapper {
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 1.25rem;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dashboard-preview {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dashboard-visual {
    width: 100%;
    height: 280px; /* Reduced height */
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(5px);
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.dashboard-chart {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60%;
    background: linear-gradient(to top, var(--current-accent), transparent);
    clip-path: polygon(0 100%, 15% 85%, 30% 90%, 45% 75%, 60% 80%, 75% 65%, 90% 70%, 100% 60%, 100% 100%);
}

.dashboard-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.5;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .parallax-section {
        background-attachment: scroll;
        min-height: 450px; /* Reduced for mobile */
    }
    
    .parallax-content {
        padding: 3rem 0;
    }
    
    .content-card {
        margin-bottom: 1.5rem;
    }
    
    .dashboard-visual {
        height: 220px;
    }
}

@media (max-width: 767px) {
    .parallax-section {
        min-height: 400px;
    }
    
    .parallax-content {
        padding: 2.5rem 0;
    }
    
    .content-header {
        padding: 1.25rem;
    }
    
    .feature-list {
        padding: 1rem;
    }
    
    .feature-list li {
        margin-bottom: 0.75rem;
    }
    
    .feature-icon {
        width: 35px;
        height: 35px;
    }
    
    .feature-icon i {
        font-size: 0.9rem;
    }
    
    .section-title-wrapper .section-title {
        padding: 0.75rem 1.5rem;
        font-size: 1.5rem;
    }
}
</style>

<script>
// Enhanced JavaScript with improved performance
document.addEventListener('DOMContentLoaded', function() {
    // Check if the browser supports parallax
    const supportsParallax = !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
    
    if (!supportsParallax) {
        document.querySelector('.parallax-section').style.backgroundAttachment = 'scroll';
    }
    
    // Throttled scroll handler for better performance
    let ticking = false;
    
    function updateParallax() {
        const parallaxSection = document.querySelector('.parallax-section');
        if (!parallaxSection) return;
        
        const scrollPosition = window.pageYOffset;
        const sectionTop = parallaxSection.offsetTop;
        const sectionHeight = parallaxSection.offsetHeight;
        
        // Check if section is in viewport
        if (scrollPosition > sectionTop - window.innerHeight && 
            scrollPosition < sectionTop + sectionHeight) {
            
            // Calculate scroll percentage
            const scrollPercentage = (scrollPosition - (sectionTop - window.innerHeight)) / 
                                    (sectionHeight + window.innerHeight);
            
            // Subtle movement for content elements (reduced effect)
            const contentCard = document.querySelector('.content-card');
            if (contentCard) {
                contentCard.style.transform = `translateY(${-scrollPercentage * 15}px)`;
            }
            
            const dashboardVisual = document.querySelector('.dashboard-visual');
            if (dashboardVisual) {
                dashboardVisual.style.transform = `translateY(${scrollPercentage * 15}px)`;
            }
        }
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
    
    // Enhanced hover effects for feature list items
    const featureItems = document.querySelectorAll('.feature-list li');
    featureItems.forEach((item, index) => {
        item.addEventListener('mouseenter', function() {
            this.querySelector('.feature-icon').style.transform = 'scale(1.1) rotate(5deg)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.querySelector('.feature-icon').style.transform = 'scale(1) rotate(0deg)';
        });
        
        // Staggered animation on load (faster)
        item.style.opacity = '0';
        item.style.transform = 'translateX(-15px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.4s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 200 + (index * 80));
    });
});
</script>

<?php include 'includes/footer.php'; ?>