<?php 
$pageTitle = "DroughtWatch - About Us";
$pageDescription = "Learn about DroughtWatch's mission to monitor and predict drought conditions through advanced research and technology.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="page-title">About DroughtWatch</h1>
            <p class="lead">Pioneering drought monitoring and prediction through cutting-edge research, advanced technology, and global collaboration.</p>
        </div>
        <div class="col-lg-6">
            <div class="about-visual">
                <div class="geometric-shapes">
                    <div class="shape shape-1" style="--rotation: 15deg;"></div>
                    <div class="shape shape-2" style="--rotation: -10deg;"></div>
                    <div class="shape shape-3" style="--rotation: 25deg;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="mission-card">
                <div class="mission-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Our Mission</h3>
                <p>To provide accurate, timely, and accessible drought monitoring and prediction services that empower communities, researchers, and policymakers to make informed decisions and build resilience against drought impacts.</p>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="vision-card">
                <div class="vision-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Our Vision</h3>
                <p>A world where drought-related risks are minimized through advanced early warning systems, comprehensive research, and collaborative global efforts to understand and mitigate drought impacts.</p>
            </div>
        </div>
    </div>

    <!-- What We Do -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="section-title text-center mb-4">What We Do</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-satellite"></i>
                        </div>
                        <h4>Real-time Monitoring</h4>
                        <p>Advanced satellite imagery and ground-based sensors provide continuous monitoring of drought conditions worldwide.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Predictive Analytics</h4>
                        <p>Machine learning algorithms analyze historical data and current conditions to forecast drought patterns and severity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Community Support</h4>
                        <p>Educational resources and tools help communities understand drought risks and implement effective mitigation strategies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="stats-section">
                <h2 class="section-title text-center mb-4">Our Impact</h2>
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">Countries Monitored</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item">
                            <div class="stat-number">1M+</div>
                            <div class="stat-label">Data Points Daily</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item">
                            <div class="stat-number">100+</div>
                            <div class="stat-label">Research Partners</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Monitoring</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technology Stack -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="section-title text-center mb-4">Our Technology</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="tech-card">
                        <h4><i class="fas fa-brain me-2"></i>Artificial Intelligence</h4>
                        <p>Advanced machine learning models process vast amounts of meteorological and satellite data to identify drought patterns and predict future conditions with unprecedented accuracy.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tech-card">
                        <h4><i class="fas fa-satellite-dish me-2"></i>Satellite Technology</h4>
                        <p>Integration with multiple satellite systems provides comprehensive coverage of vegetation health, soil moisture, and precipitation patterns across the globe.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tech-card">
                        <h4><i class="fas fa-cloud me-2"></i>Cloud Computing</h4>
                        <p>Scalable cloud infrastructure ensures real-time processing of massive datasets and provides reliable access to drought information worldwide.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tech-card">
                        <h4><i class="fas fa-mobile-alt me-2"></i>Mobile Platforms</h4>
                        <p>User-friendly mobile applications and web platforms make drought information accessible to farmers, researchers, and policymakers anywhere, anytime.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12">
            <div class="cta-section">
                <h3>Join Our Mission</h3>
                <p>Be part of the global effort to understand and combat drought. Whether you're a researcher, policymaker, or community leader, there's a place for you in our network.</p>
                <div class="cta-buttons">
                    <a href="../pages/contact.php" class="btn btn-primary btn-lg me-3">Get Involved</a>
                    <a href="../pages/researchers.php" class="btn btn-outline-primary btn-lg">Meet Our Team</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* About Page Styles */
.page-title {
    color: var(--current-text);
    font-weight: 700;
    margin-bottom: 1rem;
}

.about-visual {
    height: 300px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mission-card, .vision-card {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 2rem;
    height: 100%;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    border-left: 4px solid var(--current-accent);
}

.mission-card:hover, .vision-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-5px);
}

.mission-icon, .vision-icon {
    width: 60px;
    height: 60px;
    background: var(--current-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.mission-icon i, .vision-icon i {
    font-size: 1.5rem;
    color: var(--current-bg);
}

.section-title {
    color: var(--current-text);
    font-weight: 700;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: var(--current-accent);
}

.service-card {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    height: 100%;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}

.service-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-5px);
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.service-icon i {
    font-size: 2rem;
    color: var(--current-bg);
}

.stats-section {
    background: linear-gradient(135deg, var(--current-bg-secondary), var(--current-bg-tertiary));
    border-radius: 12px;
    padding: 3rem 2rem;
}

.stat-item {
    padding: 1rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: var(--current-accent);
    display: block;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--current-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
}

.tech-card {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}

.tech-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.tech-card h4 {
    color: var(--current-text);
    margin-bottom: 1rem;
}

.tech-card i {
    color: var(--current-accent);
}

.cta-section {
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
    color: var(--current-bg);
    padding: 3rem;
    border-radius: 12px;
    text-align: center;
}

.cta-section h3 {
    margin-bottom: 1rem;
    font-weight: 700;
}

.cta-section p {
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons .btn {
    margin-bottom: 1rem;
}

.cta-section .btn-primary {
    background: var(--current-bg);
    color: var(--current-accent);
    border: none;
}

.cta-section .btn-outline-primary {
    border-color: var(--current-bg);
    color: var(--current-bg);
}

.cta-section .btn:hover {
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .cta-buttons {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .cta-buttons .btn {
        margin: 0;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}
</style>

<?php include '../includes/footer.php'; ?>