<?php 
require_once '../config/db.php';
$pageTitle = "DroughtWatch - Latest News";
$pageDescription = "Latest news and updates from DroughtWatch.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <!-- Simple Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Latest News</h1>
        </div>
    </div>

    <!-- Time Filter Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                <button class="filter-btn active" data-timeframe="all">All Time</button>
                <button class="filter-btn" data-timeframe="today">Today</button>
                <button class="filter-btn" data-timeframe="week">This Week</button>
                <button class="filter-btn" data-timeframe="month">This Month</button>
                <button class="filter-btn" data-timeframe="year">This Year</button>
            </div>
        </div>
    </div>

    <!-- News Articles -->
    <div class="row g-4" id="news-grid">
        <?php
        $sql = "SELECT id, title, content, image_url, publish_date FROM news ORDER BY publish_date DESC";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Calculate time difference for filtering
                $publish_timestamp = strtotime($row['publish_date']);
                $now = time();
                $time_diff = $now - $publish_timestamp;
                
                // Determine time category
                $time_category = 'all';
                if ($time_diff <= 86400) { // 24 hours
                    $time_category = 'today';
                } elseif ($time_diff <= 604800) { // 7 days
                    $time_category = 'week';
                } elseif ($time_diff <= 2592000) { // 30 days
                    $time_category = 'month';
                } elseif ($time_diff <= 31536000) { // 365 days
                    $time_category = 'year';
                }
                
                // Handle image path
                $image_url = '';
                if (!empty($row['image_url'])) {
                    // Check if it's a URL or file path
                    if (filter_var($row['image_url'], FILTER_VALIDATE_URL)) {
                        $image_url = $row['image_url'];
                    } else {
                        // Assume it's a file path relative to the site root
                        $image_url = $basePath . ltrim($row['image_url'], '/');
                    }
                } else {
                    $image_url = $basePath . 'assets/images/placeholder.jpg';
                }
                
                // Content preview
                $full_content = strip_tags($row['content']);
                $preview_length = 200;
                $preview_content = mb_substr($full_content, 0, $preview_length);
                $has_more_content = mb_strlen($full_content) > $preview_length;
        ?>
                <div class="col-md-12 mb-4 news-article" 
                     data-timeframe="<?php echo $time_category; ?>" 
                     data-publish-date="<?php echo $publish_timestamp; ?>"
                     id="news-<?php echo $row['id']; ?>">
                    <div class="card">
                        <div class="row g-0">
                            <?php if (!empty($row['image_url'])): ?>
                            <div class="col-md-4">
                                <img src="<?php echo htmlspecialchars($image_url); ?>" 
                                     class="img-fluid rounded-start news-image" 
                                     alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </div>
                            <div class="col-md-8">
                            <?php else: ?>
                            <div class="col-md-12">
                            <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            <?php echo date('F j, Y, g:i a', $publish_timestamp); ?>
                                            <?php 
                                            if ($time_diff < 86400) { // Less than 24 hours
                                                echo ' <span class="badge bg-primary">';
                                                if ($time_diff < 3600) {
                                                    echo floor($time_diff / 60) . ' minutes ago';
                                                } else {
                                                    echo floor($time_diff / 3600) . ' hours ago';
                                                }
                                                echo '</span>';
                                            }
                                            ?>
                                        </small>
                                    </p>
                                    
                                    <div class="news-content">
                                        <div class="content-preview">
                                            <?php echo nl2br(htmlspecialchars($preview_content)); ?>
                                            <?php if ($has_more_content): ?>
                                                <span class="content-ellipsis">...</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($has_more_content): ?>
                                            <div class="content-full" style="display: none;">
                                                <?php echo nl2br(htmlspecialchars($full_content)); ?>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-primary see-more-btn">
                                                    See Full Article
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary see-less-btn" style="display: none;">
                                                    See Less
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
            $result->free();
        } else {
            echo '<div class="col-12 alert alert-info">No news articles found.</div>';
        }
        ?>
    </div>
    
    <!-- No Results Message -->
    <div class="row mt-4" id="no-results" style="display: none;">
        <div class="col-12">
            <div class="alert alert-info">
                No articles found for the selected time period.
            </div>
        </div>
    </div>
</div>

<style>
/* Simple styles for news page */
.page-title {
    color: var(--current-text);
    margin-bottom: 1.5rem;
    font-weight: 700;
}

.filter-btn {
    background: var(--current-bg-secondary);
    border: 2px solid transparent;
    color: var(--current-text);
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--current-accent);
    color: var(--current-bg);
    border-color: var(--current-accent);
}

.news-image {
    width: 100%;
    height: 250px;           /* Fixed height for all images */
    object-fit: cover;       /* Ensures image covers the box */
    border-radius: 8px 0 0 8px;
    display: block;
}

.content-ellipsis {
    color: var(--current-accent);
    font-weight: 600;
}

.news-article {
    transition: all 0.3s ease;
}

.news-article.hidden {
    display: none;
}

.see-more-btn, .see-less-btn {
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .news-image {
        max-height: 200px;
        width: 100%;
    }
}
</style>

<script>
// Simple news functionality
document.addEventListener('DOMContentLoaded', function() {
    initTimeFilters();
    initSeeMoreLess();
});

function initTimeFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const newsArticles = document.querySelectorAll('.news-article');
    const noResults = document.getElementById('no-results');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const timeframe = this.getAttribute('data-timeframe');
            
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter articles
            let visibleCount = 0;
            const now = Math.floor(Date.now() / 1000);
            
            newsArticles.forEach(article => {
                const publishDate = parseInt(article.getAttribute('data-publish-date'));
                const timeDiff = now - publishDate;
                let shouldShow = false;
                
                switch(timeframe) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'today':
                        shouldShow = timeDiff <= 86400; // 24 hours
                        break;
                    case 'week':
                        shouldShow = timeDiff <= 604800; // 7 days
                        break;
                    case 'month':
                        shouldShow = timeDiff <= 2592000; // 30 days
                        break;
                    case 'year':
                        shouldShow = timeDiff <= 31536000; // 365 days
                        break;
                }
                
                if (shouldShow) {
                    article.classList.remove('hidden');
                    visibleCount++;
                } else {
                    article.classList.add('hidden');
                }
            });
            
            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
    });
}

function initSeeMoreLess() {
    const seeMoreBtns = document.querySelectorAll('.see-more-btn');
    const seeLessBtns = document.querySelectorAll('.see-less-btn');
    
    seeMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const article = this.closest('.news-article');
            const preview = article.querySelector('.content-preview');
            const full = article.querySelector('.content-full');
            const seeLessBtn = article.querySelector('.see-less-btn');
            
            // Hide preview and show full content
            preview.style.display = 'none';
            full.style.display = 'block';
            
            // Switch buttons
            this.style.display = 'none';
            seeLessBtn.style.display = 'inline-block';
            
            // Smooth scroll to keep the article in view
            article.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
    
    seeLessBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const article = this.closest('.news-article');
            const preview = article.querySelector('.content-preview');
            const full = article.querySelector('.content-full');
            const seeMoreBtn = article.querySelector('.see-more-btn');
            
            // Hide full content and show preview
            full.style.display = 'none';
            preview.style.display = 'block';
            
            // Switch buttons
            this.style.display = 'none';
            seeMoreBtn.style.display = 'inline-block';
            
            // Smooth scroll to keep the article in view
            article.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
}
</script>

<?php include '../includes/footer.php'; ?>