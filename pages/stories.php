<?php 
require_once '../config/db.php';
$pageTitle = "DroughtWatch - Community Stories";
$pageDescription = "Read inspiring stories from communities affected by drought and their resilience journeys.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <!-- Page Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="page-title">Community Stories</h1>
            <p class="text-muted">Real stories of resilience, adaptation, and hope from drought-affected communities</p>
        </div>
        <div class="col-md-4">
            <div class="story-stats">
                <?php
                $total_stories = $mysqli->query("SELECT COUNT(*) as count FROM stories")->fetch_assoc()['count'];
                $recent_stories = $mysqli->query("SELECT COUNT(*) as count FROM stories WHERE publish_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch_assoc()['count'];
                ?>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $total_stories; ?></span>
                    <span class="stat-label">Total Stories</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $recent_stories; ?></span>
                    <span class="stat-label">This Month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stories Grid -->
    <div class="row g-4" id="stories-grid">
        <?php
        $sql = "SELECT id, title, author, narrative, publish_date FROM stories ORDER BY publish_date DESC";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            $story_count = 0;
            while ($row = $result->fetch_assoc()) {
                $story_count++;
                $publish_date = new DateTime($row['publish_date']);
                $full_narrative = strip_tags($row['narrative']);
                $preview_length = $story_count === 1 ? 300 : 200; // First story gets more preview
                $preview_narrative = mb_substr($full_narrative, 0, $preview_length);
                $has_more_content = mb_strlen($full_narrative) > $preview_length;
                
                // Determine card size - make first story featured
                $card_class = $story_count === 1 ? 'col-12' : 'col-md-6';
                $is_featured = $story_count === 1;
        ?>
                <div class="<?php echo $card_class; ?> story-item" id="story-<?php echo $row['id']; ?>">
                    <article class="story-card <?php echo $is_featured ? 'featured-story' : ''; ?>">
                        <div class="story-header">
                            <div class="story-meta">
                                <span class="story-date">
                                    <i class="far fa-calendar me-1"></i>
                                    <?php echo $publish_date->format('F j, Y'); ?>
                                </span>
                                <span class="story-author">
                                    <i class="fas fa-user me-1"></i>
                                    <?php echo htmlspecialchars($row['author']); ?>
                                </span>
                            </div>
                            <?php if ($is_featured): ?>
                                <span class="featured-badge">Featured Story</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="story-content">
                            <h3 class="story-title <?php echo $is_featured ? 'h2' : ''; ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </h3>
                            
                            <div class="story-narrative">
                                <div class="narrative-preview">
                                    <?php echo nl2br(htmlspecialchars($preview_narrative)); ?>
                                    <?php if ($has_more_content): ?>
                                        <span class="narrative-ellipsis">...</span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($has_more_content): ?>
                                    <div class="narrative-full" style="display: none;">
                                        <?php echo nl2br(htmlspecialchars($full_narrative)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($has_more_content): ?>
                                <div class="story-actions mt-3">
                                    <button class="btn btn-primary read-more-btn">
                                        Read Full Story
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </button>
                                    <button class="btn btn-outline-primary read-less-btn" style="display: none;">
                                        Show Less
                                        <i class="fas fa-arrow-up ms-1"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="story-footer">
                            <div class="story-tags">
                                <span class="story-tag">Community</span>
                                <span class="story-tag">Resilience</span>
                                <span class="story-tag">Drought Impact</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm share-story-btn" 
                                    data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                    data-url="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '#story-' . $row['id']; ?>">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </article>
                </div>
        <?php
            }
            $result->free();
        } else {
            echo '<div class="col-12 alert alert-info">No stories found.</div>';
        }
        ?>
    </div>
    
    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="story-cta">
                <h3>Share Your Story</h3>
                <p>Have a drought-related story to share? We'd love to hear from your community.</p>
                <button class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Submit Your Story
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Stories Page Styles */
.page-title {
    color: var(--current-text);
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.story-stats {
    display: flex;
    gap: 2rem;
    justify-content: flex-end;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--current-accent);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--current-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.story-card {
    background: var(--current-bg);
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    padding: 2rem;
    height: 100%;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.story-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-3px);
}

.featured-story {
    background: linear-gradient(135deg, var(--current-bg-secondary) 0%, var(--current-bg-tertiary) 100%);
    border: 2px solid var(--current-accent);
}

.story-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.story-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--current-text-muted);
}

.featured-badge {
    background: var(--current-accent);
    color: var(--current-bg);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.story-title {
    color: var(--current-text);
    margin-bottom: 1.5rem;
    line-height: 1.3;
    font-weight: 600;
}

.story-narrative {
    color: var(--current-text-secondary);
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.narrative-ellipsis {
    color: var(--current-accent);
    font-weight: 600;
}

.story-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 1.5rem;
    border-top: 1px solid var(--current-bg-secondary);
}

.story-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.story-tag {
    background: var(--current-bg-secondary);
    color: var(--current-text-muted);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

.story-cta {
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
    color: var(--current-bg);
    padding: 3rem;
    border-radius: 12px;
    text-align: center;
}

.story-cta h3 {
    margin-bottom: 1rem;
    font-weight: 700;
}

.story-cta p {
    margin-bottom: 2rem;
    opacity: 0.9;
}

.story-cta .btn {
    background: var(--current-bg);
    color: var(--current-accent);
    border: none;
}

.story-cta .btn:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .story-stats {
        justify-content: center;
        margin-top: 1rem;
    }
    
    .story-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .story-meta {
        flex-direction: row;
        gap: 1rem;
    }
    
    .story-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .story-cta {
        padding: 2rem 1rem;
    }
}
</style>

<script>
// Stories page functionality
document.addEventListener('DOMContentLoaded', function() {
    initStoryActions();
    initStorySharing();
});

function initStoryActions() {
    const readMoreBtns = document.querySelectorAll('.read-more-btn');
    const readLessBtns = document.querySelectorAll('.read-less-btn');
    
    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const story = this.closest('.story-card');
            const preview = story.querySelector('.narrative-preview');
            const full = story.querySelector('.narrative-full');
            const readLessBtn = story.querySelector('.read-less-btn');
            
            preview.style.display = 'none';
            full.style.display = 'block';
            this.style.display = 'none';
            readLessBtn.style.display = 'inline-block';
            
            // Smooth scroll to keep story in view
            story.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
    
    readLessBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const story = this.closest('.story-card');
            const preview = story.querySelector('.narrative-preview');
            const full = story.querySelector('.narrative-full');
            const readMoreBtn = story.querySelector('.read-more-btn');
            
            full.style.display = 'none';
            preview.style.display = 'block';
            this.style.display = 'none';
            readMoreBtn.style.display = 'inline-block';
            
            // Smooth scroll to keep story in view
            story.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
}

function initStorySharing() {
    const shareBtns = document.querySelectorAll('.share-story-btn');
    
    shareBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const title = this.getAttribute('data-title');
            const url = 'https://' + this.getAttribute('data-url');
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(err => console.log('Error sharing:', err));
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Story link copied to clipboard!');
                }).catch(err => {
                    console.log('Error copying to clipboard:', err);
                });
            }
        });
    });
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--current-accent);
        color: var(--current-bg);
        padding: 1rem 1.5rem;
        border-radius: 5px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        box-shadow: var(--shadow-lg);
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS for toast animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>

<?php include '../includes/footer.php'; ?>