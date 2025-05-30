<?php 
require_once '../config/db.php';
$pageTitle = "DroughtWatch - Events";
$pageDescription = "Discover upcoming drought research events, conferences, and community gatherings.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <!-- Page Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="page-title">Events & Conferences</h1>
            <p class="text-muted">Join us at upcoming drought research events and community gatherings</p>
        </div>
        <div class="col-md-4">
            <div class="event-stats">
                <?php
                $upcoming_count = $mysqli->query("SELECT COUNT(*) as count FROM events WHERE event_date >= NOW()")->fetch_assoc()['count'];
                $past_count = $mysqli->query("SELECT COUNT(*) as count FROM events WHERE event_date < NOW()")->fetch_assoc()['count'];
                ?>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $upcoming_count; ?></span>
                    <span class="stat-label">Upcoming</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $past_count; ?></span>
                    <span class="stat-label">Past Events</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="event-filters">
                <button class="filter-btn active" data-filter="all">All Events</button>
                <button class="filter-btn" data-filter="upcoming">Upcoming</button>
                <button class="filter-btn" data-filter="past">Past Events</button>
            </div>
        </div>
    </div>

    <!-- Events Timeline -->
    <div class="row">
        <div class="col-12">
            <div class="events-timeline" id="events-container">
                <?php
                $sql = "SELECT id, name, event_date, location, description FROM events ORDER BY event_date DESC";
                $result = $mysqli->query($sql);

                if ($result && $result->num_rows > 0) {
                    $current_year = '';
                    while ($row = $result->fetch_assoc()) {
                        $event_date = new DateTime($row['event_date']);
                        $now = new DateTime();
                        $is_upcoming = $event_date > $now;
                        $year = $event_date->format('Y');
                        
                        // Show year divider
                        if ($year !== $current_year) {
                            if ($current_year !== '') echo '</div>'; // Close previous year group
                            echo '<div class="year-group" data-year="' . $year . '">';
                            echo '<h3 class="year-divider">' . $year . '</h3>';
                            $current_year = $year;
                        }
                        
                        $event_status = $is_upcoming ? 'upcoming' : 'past';
                        $full_description = strip_tags($row['description']);
                        $preview_description = mb_substr($full_description, 0, 150);
                        $has_more_content = mb_strlen($full_description) > 150;
                ?>
                        <div class="event-item <?php echo $event_status; ?>" 
                             data-status="<?php echo $event_status; ?>"
                             id="event-<?php echo $row['id']; ?>">
                            <div class="event-card">
                                <div class="event-date-badge <?php echo $is_upcoming ? 'upcoming-badge' : 'past-badge'; ?>">
                                    <div class="date-day"><?php echo $event_date->format('d'); ?></div>
                                    <div class="date-month"><?php echo $event_date->format('M'); ?></div>
                                    <?php if ($is_upcoming): ?>
                                        <div class="upcoming-indicator">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="event-content">
                                    <div class="event-header">
                                        <h4 class="event-title"><?php echo htmlspecialchars($row['name']); ?></h4>
                                        <div class="event-meta">
                                            <span class="event-time">
                                                <i class="far fa-clock me-1"></i>
                                                <?php echo $event_date->format('g:i A'); ?>
                                            </span>
                                            <span class="event-location">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?php echo htmlspecialchars($row['location']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="event-description">
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
                                            
                                            <button class="btn btn-sm btn-outline-primary see-more-btn mt-2">
                                                Read More
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary see-less-btn mt-2" style="display: none;">
                                                Read Less
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($is_upcoming): ?>
                                        <div class="event-actions mt-3">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fas fa-calendar-plus me-1"></i>
                                                Add to Calendar
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-share-alt me-1"></i>
                                                Share
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    if ($current_year !== '') echo '</div>'; // Close last year group
                    $result->free();
                } else {
                    echo '<div class="col-12 alert alert-info">No events found.</div>';
                }
                ?>
            </div>
        </div>
    </div>
    
    <!-- No Results Message -->
    <div class="row mt-4" id="no-events" style="display: none;">
        <div class="col-12">
            <div class="alert alert-info">
                No events found for the selected filter.
            </div>
        </div>
    </div>
</div>

<style>
/* Events Page Styles */
.page-title {
    color: var(--current-text);
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.event-stats {
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

.event-filters {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
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

.year-divider {
    color: var(--current-accent);
    font-weight: 700;
    margin: 2rem 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--current-accent);
}

.event-item {
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.event-item.hidden {
    display: none;
}

.event-card {
    display: flex;
    background: var(--current-bg);
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: all 0.3s ease;
}

.event-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.event-date-badge {
    flex-shrink: 0;
    width: 100px;
    padding: 1.5rem 1rem;
    text-align: center;
    color: white;
    position: relative;
}

.upcoming-badge {
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
}

.past-badge {
    background: linear-gradient(135deg, #6c757d, #495057);
}

.date-day {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
}

.date-month {
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 0.25rem;
}

.upcoming-indicator {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.event-content {
    flex: 1;
    padding: 1.5rem;
}

.event-title {
    color: var(--current-text);
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.event-meta {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: var(--current-text-muted);
}

.event-description {
    color: var(--current-text-secondary);
    line-height: 1.6;
}

.description-ellipsis {
    color: var(--current-accent);
    font-weight: 600;
}

.event-actions {
    display: flex;
    gap: 0.75rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .event-card {
        flex-direction: column;
    }
    
    .event-date-badge {
        width: 100%;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }
    
    .date-day, .date-month {
        display: inline;
    }
    
    .event-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .event-stats {
        justify-content: center;
        margin-top: 1rem;
    }
}
</style>

<script>
// Events page functionality
document.addEventListener('DOMContentLoaded', function() {
    initEventFilters();
    initEventActions();
});

function initEventFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const eventItems = document.querySelectorAll('.event-item');
    const noEvents = document.getElementById('no-events');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter events
            let visibleCount = 0;
            
            eventItems.forEach(item => {
                const status = item.getAttribute('data-status');
                
                if (filter === 'all' || status === filter) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });
            
            // Show/hide no results message
            if (visibleCount === 0) {
                noEvents.style.display = 'block';
            } else {
                noEvents.style.display = 'none';
            }
        });
    });
}

function initEventActions() {
    // See more/less functionality
    const seeMoreBtns = document.querySelectorAll('.see-more-btn');
    const seeLessBtns = document.querySelectorAll('.see-less-btn');
    
    seeMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const event = this.closest('.event-item');
            const preview = event.querySelector('.description-preview');
            const full = event.querySelector('.description-full');
            const seeLessBtn = event.querySelector('.see-less-btn');
            
            preview.style.display = 'none';
            full.style.display = 'block';
            this.style.display = 'none';
            seeLessBtn.style.display = 'inline-block';
        });
    });
    
    seeLessBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const event = this.closest('.event-item');
            const preview = event.querySelector('.description-preview');
            const full = event.querySelector('.description-full');
            const seeMoreBtn = event.querySelector('.see-more-btn');
            
            full.style.display = 'none';
            preview.style.display = 'block';
            this.style.display = 'none';
            seeMoreBtn.style.display = 'inline-block';
        });
    });
}
</script>

<?php include '../includes/footer.php'; ?>