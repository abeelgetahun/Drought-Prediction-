/**
 * DroughtWatch Unified Application
 * Single JavaScript file to handle all functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('DroughtWatch App Initializing...');
    initializeApp();
});

function initializeApp() {
    initThemeToggle();
    initLiveSearch();
    initNavbarScrollEffect();
    initScrollAnimations();
    initSmoothScrolling();
    initGeometricShapes();
    loadSavedTheme();
    console.log('DroughtWatch App Initialized Successfully');
}

/**
 * Theme Toggle Functionality
 */
function initThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    if (!themeToggle) {
        console.log('Theme toggle not found');
        return;
    }
    
    themeToggle.addEventListener('click', function() {
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('droughtwatch-theme', newTheme);
        updateGeometricShapes();
        
        console.log('Theme changed to:', newTheme);
    });
}

/**
 * Load saved theme preference
 */
function loadSavedTheme() {
    const savedTheme = localStorage.getItem('droughtwatch-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme) {
        document.documentElement.setAttribute('data-theme', savedTheme);
        console.log('Loaded saved theme:', savedTheme);
    } else if (prefersDark) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('droughtwatch-theme', 'dark');
        console.log('Applied dark theme based on system preference');
    }
    
    updateGeometricShapes();
}

/**
 * Update geometric shapes based on theme
 */
function updateGeometricShapes() {
    const shapes = document.querySelectorAll('.shape');
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const accentColor = currentTheme === 'dark' ? '#ffed4e' : '#ffd700';
    
    shapes.forEach(shape => {
        shape.style.background = `linear-gradient(135deg, ${accentColor}, rgba(255, 215, 0, 0.1))`;
    });
}

/**
 * Live Search Functionality
 */
function initLiveSearch() {
    const searchToggle = document.getElementById('searchToggle');
    const searchPanel = document.getElementById('searchPanel');
    const searchPanelClose = document.getElementById('searchPanelClose');
    const searchInput = document.getElementById('liveSearchInput');
    const searchResults = document.getElementById('searchResults');
    const filterBtns = document.querySelectorAll('.filter-btn');

    if (!searchToggle || !searchPanel) {
        console.log('Search elements not found');
        return;
    }

    let searchTimeout;
    let currentFilter = 'all';

    console.log('Search functionality initialized');

    // Open search panel
    searchToggle.addEventListener('click', function() {
        console.log('Search panel opened');
        searchPanel.classList.add('active');
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 300);
    });

    // Close search panel
    if (searchPanelClose) {
        searchPanelClose.addEventListener('click', closeSearch);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchPanel.classList.contains('active')) {
            closeSearch();
        }
    });

    function closeSearch() {
        console.log('Search panel closed');
        searchPanel.classList.remove('active');
        if (searchInput) {
            searchInput.value = '';
            showPlaceholder();
        }
    }

    // Filter buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            console.log('Filter changed to:', currentFilter);
            
            if (searchInput && searchInput.value.trim()) {
                performSearch(searchInput.value.trim(), currentFilter);
            }
        });
    });

    // Live search input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length === 0) {
                showPlaceholder();
                return;
            }
            
            if (query.length >= 1) {
                showLoading();
                searchTimeout = setTimeout(() => {
                    performSearch(query, currentFilter);
                }, 300);
            }
        });
    }

    function showPlaceholder() {
        if (searchResults) {
            searchResults.innerHTML = `
                <div class="search-placeholder">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <p>Start typing to search across all content...</p>
                </div>
            `;
        }
    }

    function showLoading() {
        if (searchResults) {
            searchResults.innerHTML = `
                <div class="search-loading">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Searching...</p>
                </div>
            `;
        }
    }

    function showNoResults(query) {
        if (searchResults) {
            searchResults.innerHTML = `
                <div class="search-no-results">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <h5>No results found</h5>
                    <p>No results found for "${query}". Try different keywords or check your spelling.</p>
                </div>
            `;
        }
    }

    function performSearch(query, filter) {
        const basePath = getBasePath();
        const searchUrl = `${basePath}search-handler.php?q=${encodeURIComponent(query)}&filter=${filter}`;
        
        console.log('Performing search:', { query, filter, url: searchUrl });
        
        fetch(searchUrl)
            .then(response => {
                console.log('Search response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Search results:', data);
                if (data.success && data.results && data.results.length > 0) {
                    displayResults(data.results, query);
                } else {
                    showNoResults(query);
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                if (searchResults) {
                    searchResults.innerHTML = `
                        <div class="search-no-results">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h5>Search Error</h5>
                            <p>An error occurred while searching: ${error.message}</p>
                            <p class="small">Check console for details.</p>
                        </div>
                    `;
                }
            });
    }

    function displayResults(results, query) {
        if (!searchResults) return;

        const typeColors = {
            'news': '#007bff',
            'events': '#28a745',
            'researchers': '#6f42c1',
            'stories': '#fd7e14',
            'focus': '#dc3545'
        };

        const resultsHtml = results.map(result => {
            const typeColor = typeColors[result.type] || '#6c757d';
            const basePath = getBasePath();
            
            return `
                <div class="search-result-item">
                    <span class="search-result-type" style="background-color: ${typeColor};">${result.type}</span>
                    <h6><a href="${basePath}${result.url}">${highlightText(result.title, query)}</a></h6>
                    ${result.date ? `<div class="search-result-meta"><i class="far fa-calendar me-1"></i>${formatDate(result.date)}</div>` : ''}
                    <p class="search-result-excerpt">${highlightText(result.excerpt, query)}</p>
                </div>
            `;
        }).join('');

        searchResults.innerHTML = resultsHtml;
    }

    function highlightText(text, query) {
        if (!query || !text) return text;
        const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    function escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
    }

    function getBasePath() {
        const path = window.location.pathname;
        console.log('Current path:', path);
        if (path.includes('/pages/')) {
            return '../';
        }
        return '';
    }
}

/**
 * Navbar scroll effect
 */
function initNavbarScrollEffect() {
    const navbar = document.querySelector('.navbar');
    
    if (!navbar) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
}

/**
 * Scroll animations
 */
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.card, .content-section > .container > *');
    animatedElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(element);
    });
}

/**
 * Smooth scrolling for anchor links
 */
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                const offsetTop = targetElement.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Animate geometric shapes
 */
function initGeometricShapes() {
    const shapes = document.querySelectorAll('.shape');
    
    shapes.forEach((shape, index) => {
        setInterval(() => {
            const randomX = (Math.random() - 0.5) * 10;
            const randomY = (Math.random() - 0.5) * 10;
            const currentRotation = shape.style.getPropertyValue('--rotation') || '0deg';
            
            shape.style.transform = `translate(${randomX}px, ${randomY}px) rotate(${currentRotation})`;
        }, 3000 + (index * 1000));
    });
}

/**
 * Enhanced button interactions
 */
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
    });
    
    button.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

/**
 * Error handling
 */
window.addEventListener('error', function(e) {
    console.error('DroughtWatch App Error:', e.error);
});

// Reduced motion support
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.style.setProperty('--transition-fast', '0s');
    document.documentElement.style.setProperty('--transition-medium', '0s');
    document.documentElement.style.setProperty('--transition-slow', '0s');
}