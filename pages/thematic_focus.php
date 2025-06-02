<?php 
require_once '../config/db.php';
$pageTitle = "DroughtWatch - Thematic Focus Areas";
$pageDescription = "Explore our key research focus areas in drought monitoring, prediction, and mitigation strategies.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <!-- Page Header -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="page-title">Thematic Focus Areas</h1>
            <p class="lead">Our research spans multiple interconnected areas of drought science, from early warning systems to community resilience building.</p>
        </div>
        <div class="col-lg-4">
            <div class="focus-stats">
                <?php
                $total_focus = $mysqli->query("SELECT COUNT(*) as count FROM focus")->fetch_assoc()['count'];
                ?>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $total_focus; ?></span>
                    <span class="stat-label">Focus Areas</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Focus Areas Grid -->
    <div class="row g-4" id="focus-grid">
        <?php
        $sql = "SELECT id, name, description FROM focus ORDER BY name ASC";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            $focus_count = 0;
            $focus_icons = [
                'fas fa-satellite',
                'fas fa-chart-line',
                'fas fa-seedling',
                'fas fa-water',
                'fas fa-cloud-rain',
                'fas fa-users',
                'fas fa-shield-alt',
                'fas fa-globe-americas'
            ];
            
            while ($row = $result->fetch_assoc()) {
                $focus_count++;
                $icon = $focus_icons[($focus_count - 1) % count($focus_icons)];
                $full_description = strip_tags($row['description']);
                $preview_length = 150;
                $preview_description = mb_substr($full_description, 0, $preview_length);
                $has_more_content = mb_strlen($full_description) > $preview_length;
        ?>
                <div class="col-md-6 col-lg-4 focus-item" id="focus-<?php echo $row['id']; ?>">
                    <div class="focus-card">
                        <div class="focus-header">
                            <div class="focus-icon">
                                <i class="<?php echo $icon; ?>"></i>
                            </div>
                            <h3 class="focus-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                        </div>
                        
                        <div class="focus-content">
                            <div class="description-preview">
                                <?php echo nl2br(htmlspecialchars($preview_description)); ?>
                                <?php if ($has_more_content): ?>
                                    <span class="description-ellipsis">...</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($has_more_content): ?>
                                <div class="description-full" style="display: none;">
                                    <?php echo nl2br(htmlspecialchars($full_description)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="focus-actions">
                            <?php if ($has_more_content): ?>
                                <button class="btn btn-outline-primary btn-sm read-more-btn">
                                    Learn More
                                </button>
                                <button class="btn btn-outline-primary btn-sm read-less-btn" style="display: none;">
                                    Show Less
                                </button>
                            <?php endif; ?>
                            <button class="btn btn-primary btn-sm explore-btn" 
                                    data-focus="<?php echo htmlspecialchars($row['name']); ?>">
                                Explore Research
                            </button>
                        </div>
                    </div>
                </div>
        <?php
            }
            $result->free();
        } else {
            echo '<div class="col-12 alert alert-info">No thematic focus areas found.</div>';
        }
        ?>
    </div>
    
    <!-- Research Integration Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="integration-section">
                <h2 class="section-title text-center mb-4">Integrated Research Approach</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="integration-card">
                            <div class="integration-icon">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <h4>Scientific Research</h4>
                            <p>Fundamental research in drought mechanisms, climate patterns, and environmental impacts.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="integration-card">
                            <div class="integration-icon">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h4>Technology Development</h4>
                            <p>Advanced monitoring systems, predictive models, and data visualization tools.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="integration-card">
                            <div class="integration-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h4>Community Engagement</h4>
                            <p>Collaborative partnerships with communities, policymakers, and stakeholders.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="focus-cta">
                <h3>Collaborate with Us</h3>
                <p>Interested in contributing to our research or exploring partnership opportunities?</p>
                <div class="cta-buttons">
                    <a href="../pages/contact.php" class="btn btn-primary btn-lg me-3">Get Involved</a>
                    <a href="../pages/researchers.php" class="btn btn-outline-primary btn-lg">Meet Our Researchers</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Thematic Focus Page Styles */
.page-title {
    color: var(--current-text);
    font-weight: 700;
    margin-bottom: 1rem;
}

.focus-stats {
    text-align: center;
}

.stat-item {
    padding: 1rem;
}

.stat-number {
    display: block;
    font-size: 3rem;
    font-weight: 700;
    color: var(--current-accent);
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--current-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
}

.focus-card {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 2rem;
    height: 100%;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.focus-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-5px);
}

.focus-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.focus-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    transition: all 0.3s ease;
}

.focus-card:hover .focus-icon {
    transform: scale(1.1) rotate(5deg);
}

.focus-icon i {
    font-size: 2rem;
    color: var(--current-bg);
}

.focus-title {
    color: var(--current-text);
    font-weight: 600;
    margin: 0;
    font-size: 1.25rem;
}

.focus-content {
    flex: 1;
    color: var(--current-text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.description-ellipsis {
    color: var(--current-accent);
    font-weight: 600;
}

.focus-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
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

.integration-section {
    background: linear-gradient(135deg, var(--current-bg-secondary), var(--current-bg-tertiary));
    border-radius: 12px;
    padding: 3rem 2rem;
}

.integration-card {
    text-align: center;
    padding: 1.5rem;
}

.integration-icon {
    width: 60px;
    height: 60px;
    background: var(--current-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.integration-icon i {
    font-size: 1.5rem;
    color: var(--current-bg);
}

.integration-card h4 {
    color: var(--current-text);
    margin-bottom: 1rem;
    font-weight: 600;
}

.focus-cta {
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
    color: var(--current-bg);
    padding: 3rem;
    border-radius: 12px;
    text-align: center;
}

.focus-cta h3 {
    margin-bottom: 1rem;
    font-weight: 700;
}

.focus-cta p {
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons .btn {
    margin-bottom: 1rem;
}

.focus-cta .btn-primary {
    background: var(--current-bg);
    color: var(--current-accent);
    border: none;
}

.focus-cta .btn-outline-primary {
    border-color: var(--current-bg);
    color: var(--current-bg);
}

.focus-cta .btn:hover {
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .focus-actions {
        flex-direction: column;
    }
    
    .cta-buttons {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .cta-buttons .btn {
        margin: 0;
    }
}
</style>

<script>
// Thematic Focus page functionality
document.addEventListener('DOMContentLoaded', function() {
    initFocusActions();
    initExploreButtons();
});

function initFocusActions() {
    const readMoreBtns = document.querySelectorAll('.read-more-btn');
    const readLessBtns = document.querySelectorAll('.read-less-btn');
    
    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.focus-card');
            const preview = card.querySelector('.description-preview');
            const full = card.querySelector('.description-full');
            const readLessBtn = card.querySelector('.read-less-btn');
            
            preview.style.display = 'none';
            full.style.display = 'block';
            this.style.display = 'none';
            readLessBtn.style.display = 'inline-block';
        });
    });
    
    readLessBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.focus-card');
            const preview = card.querySelector('.description-preview');
            const full = card.querySelector('.description-full');
            const readMoreBtn = card.querySelector('.read-more-btn');
            
            full.style.display = 'none';
            preview.style.display = 'block';
            this.style.display = 'none';
            readMoreBtn.style.display = 'inline-block';
        });
    });
}

function initExploreButtons() {
    const exploreBtns = document.querySelectorAll('.explore-btn');
    
    exploreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const focus = this.getAttribute('data-focus');
            // In a real implementation, this would navigate to research filtered by focus area
            alert(`Exploring research in: ${focus}`);
        });
    });
}
</script>

<?php include '../includes/footer.php'; ?>