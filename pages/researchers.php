<?php 
require_once '../config/db.php';
$pageTitle = "DroughtWatch - Our Researchers";
$pageDescription = "Meet the dedicated researchers behind DroughtWatch's drought monitoring and prediction platform.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <!-- Page Header with Search -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="page-title">Our Researchers</h1>
            <p class="text-muted">Meet the experts behind our drought research and monitoring</p>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="researcherSearch" class="form-control" placeholder="Search researchers...">
                <button class="btn btn-primary" type="button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Research Focus Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="research-filters">
                <button class="filter-btn active" data-focus="all">All Areas</button>
                <?php
                // Get unique research focus areas
                $focus_sql = "SELECT DISTINCT research_focus FROM researchers WHERE research_focus IS NOT NULL AND research_focus != '' ORDER BY research_focus";
                $focus_result = $mysqli->query($focus_sql);
                if ($focus_result && $focus_result->num_rows > 0) {
                    while ($focus_row = $focus_result->fetch_assoc()) {
                        echo '<button class="filter-btn" data-focus="' . htmlspecialchars($focus_row['research_focus']) . '">' . 
                             htmlspecialchars($focus_row['research_focus']) . '</button>';
                    }
                    $focus_result->free();
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Researchers Grid -->
    <div class="row g-4" id="researchers-grid">
        <?php
        $sql = "SELECT id, name, bio, photo_url, research_focus FROM researchers ORDER BY name ASC";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Handle image path
                $photo_url = '';
                if (!empty($row['photo_url'])) {
                    // Check if it's a URL or file path
                    if (filter_var($row['photo_url'], FILTER_VALIDATE_URL)) {
                        $photo_url = $row['photo_url'];
                    } else {
                        // Assume it's a file path relative to the site root
                        $photo_url = $basePath . ltrim($row['photo_url'], '/');
                    }
                } else {
                    $photo_url = $basePath . 'assets/images/researcher-placeholder.jpg';
                }
                
                // Get a short bio for preview
                $bio_full = strip_tags($row['bio']);
                $bio_preview = mb_substr($bio_full, 0, 120) . (mb_strlen($bio_full) > 120 ? '...' : '');
                
                // Research focus for filtering
                $research_focus = !empty($row['research_focus']) ? htmlspecialchars($row['research_focus']) : 'General';
        ?>
                <div class="col-md-6 col-lg-4 researcher-card" 
                     data-name="<?php echo htmlspecialchars(strtolower($row['name'])); ?>"
                     data-focus="<?php echo strtolower($research_focus); ?>"
                     id="researcher-<?php echo $row['id']; ?>">
                    <div class="card h-100 researcher-profile">
                        <div class="researcher-image-container">
                            <img src="<?php echo htmlspecialchars($photo_url); ?>" 
                                 class="researcher-image" 
                                 alt="<?php echo htmlspecialchars($row['name']); ?>"
                                 onerror="this.src='<?php echo $basePath; ?>assets/images/researcher-placeholder.jpg'">
                            <div class="researcher-overlay">
                                <span class="researcher-focus-badge"><?php echo $research_focus; ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="researcher-name"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="researcher-bio"><?php echo htmlspecialchars($bio_preview); ?></p>
                            <button class="btn btn-primary view-profile-btn" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                    data-bio="<?php echo htmlspecialchars($row['bio']); ?>"
                                    data-photo="<?php echo htmlspecialchars($photo_url); ?>"
                                    data-focus="<?php echo $research_focus; ?>">
                                View Profile
                            </button>
                        </div>
                    </div>
                </div>
        <?php
            }
            $result->free();
        } else {
            echo '<div class="col-12 alert alert-info">No researcher profiles found.</div>';
        }
        ?>
    </div>
    
    <!-- No Results Message -->
    <div class="row mt-4" id="no-results" style="display: none;">
        <div class="col-12">
            <div class="alert alert-info">
                No researchers found matching your search criteria.
            </div>
        </div>
    </div>
</div>

<!-- Researcher Profile Modal -->
<div class="modal fade" id="researcherModal" tabindex="-1" aria-labelledby="researcherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="researcherModalLabel">Researcher Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img id="modalResearcherPhoto" src="/placeholder.svg" alt="" class="img-fluid rounded researcher-modal-image">
                        <div class="mt-3">
                            <span id="modalResearcherFocus" class="researcher-focus-badge-lg"></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3 id="modalResearcherName"></h3>
                        <div id="modalResearcherBio" class="researcher-full-bio"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="contactResearcherBtn">
                    <i class="fas fa-envelope me-2"></i>Contact
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Researcher Page Styles */
.page-title {
    color: var(--current-text);
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.research-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
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

.researcher-card {
    transition: all 0.3s ease;
}

.researcher-profile {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    background: var(--current-bg);
}

.researcher-profile:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.researcher-image-container {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.researcher-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.researcher-profile:hover .researcher-image {
    transform: scale(1.05);
}

.researcher-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    pointer-events: none;
}

.researcher-focus-badge {
    background: var(--current-accent);
    color: var(--current-bg);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.researcher-focus-badge-lg {
    background: var(--current-accent);
    color: var(--current-bg);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.researcher-name {
    color: var(--current-text);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.researcher-bio {
    color: var(--current-text-secondary);
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.researcher-full-bio {
    color: var(--current-text-secondary);
    line-height: 1.6;
    white-space: pre-line;
}

.view-profile-btn {
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.view-profile-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: -1;
}

.view-profile-btn:hover::after {
    transform: translateX(0);
}

.researcher-modal-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: var(--shadow-md);
}

/* Animation for filtered content */
.researcher-card.hidden {
    display: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .research-filters {
        justify-content: center;
    }
    
    .filter-btn {
        font-size: 0.875rem;
        padding: 0.4rem 1rem;
    }
    
    .researcher-image-container {
        height: 220px;
    }
}
</style>

<script>
// Researcher page functionality
document.addEventListener('DOMContentLoaded', function() {
    initResearcherFilters();
    initResearcherSearch();
    initResearcherModals();
});

function initResearcherFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const researcherCards = document.querySelectorAll('.researcher-card');
    const noResults = document.getElementById('no-results');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const focus = this.getAttribute('data-focus').toLowerCase();
            
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter researchers
            let visibleCount = 0;
            
            researcherCards.forEach(card => {
                const cardFocus = card.getAttribute('data-focus').toLowerCase();
                
                if (focus === 'all' || cardFocus === focus) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
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

function initResearcherSearch() {
    const searchInput = document.getElementById('researcherSearch');
    const searchButton = document.getElementById('searchButton');
    const researcherCards = document.querySelectorAll('.researcher-card');
    const noResults = document.getElementById('no-results');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;
        
        if (searchTerm === '') {
            // Reset search
            researcherCards.forEach(card => {
                card.classList.remove('hidden');
            });
            noResults.style.display = 'none';
            return;
        }
        
        researcherCards.forEach(card => {
            const name = card.getAttribute('data-name');
            const focus = card.getAttribute('data-focus');
            
            if (name.includes(searchTerm) || focus.includes(searchTerm)) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }
    
    searchButton.addEventListener('click', performSearch);
    
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
}

function initResearcherModals() {
    const viewProfileBtns = document.querySelectorAll('.view-profile-btn');
    const modal = document.getElementById('researcherModal');
    const modalName = document.getElementById('modalResearcherName');
    const modalBio = document.getElementById('modalResearcherBio');
    const modalPhoto = document.getElementById('modalResearcherPhoto');
    const modalFocus = document.getElementById('modalResearcherFocus');
    const contactBtn = document.getElementById('contactResearcherBtn');
    
    viewProfileBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const bio = this.getAttribute('data-bio');
            const photo = this.getAttribute('data-photo');
            const focus = this.getAttribute('data-focus');
            
            modalName.textContent = name;
            modalBio.textContent = bio;
            modalPhoto.src = photo;
            modalPhoto.alt = name;
            modalFocus.textContent = focus;
            
            // Initialize Bootstrap modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    });
    
    contactBtn.addEventListener('click', function() {
        const name = modalName.textContent;
        alert(`Contact form for ${name} would open here.`);
    });
}
</script>

<?php include '../includes/footer.php'; ?>