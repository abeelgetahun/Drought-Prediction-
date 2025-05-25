document.addEventListener('DOMContentLoaded', function () {
    const tickerList = document.getElementById('news-ticker-list');
    if (tickerList) {
        const tickerContent = tickerList.parentElement;
        let scrollAmount = 0;

        // Clone list items to create a seamless loop for horizontal scroll
        const listItems = Array.from(tickerList.children);
        listItems.forEach(item => {
            const clone = item.cloneNode(true);
            tickerList.appendChild(clone);
        });

        function scrollTicker() {
            scrollAmount -= 1; // Adjust speed by changing this value
            // If the first half of items has scrolled out of view, reset
            if (Math.abs(scrollAmount) >= tickerList.scrollWidth / 2) {
                scrollAmount = 0;
            }
            tickerList.style.transform = 'translateX(' + scrollAmount + 'px)';
            requestAnimationFrame(scrollTicker);
        }

        // Only start scrolling if there's content to scroll
        if (listItems.length > 0 && tickerList.scrollWidth > tickerContent.offsetWidth) {
            requestAnimationFrame(scrollTicker);
        }
    }

    // Night Mode Toggle Icon Change
    const nightModeToggle = document.getElementById('night-mode-toggle');
    if (nightModeToggle) {
        nightModeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-moon')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                // document.body.classList.add('night-mode'); // Example: Add class to body
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                // document.body.classList.remove('night-mode'); // Example: Remove class from body
            }
            // Actual theme switching logic would go here
            alert("Night mode toggle clicked! (Functionality not yet implemented)");
        });
    }

    // Search Icon Click (Placeholder)
    const searchIcon = document.getElementById('search-icon');
    if (searchIcon) {
        searchIcon.addEventListener('click', function(e) {
            e.preventDefault();
            // Implement search overlay or redirect to a search page
            alert("Search icon clicked! (Functionality not yet implemented)");
        });
    }

    // Fade-in animation for research cards on homepage
    const researchCards = document.querySelectorAll('.research-card');
    if (researchCards.length > 0 && 'IntersectionObserver' in window) {
        let cardObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 }); // Trigger when 10% of the card is visible

        researchCards.forEach(function(card) {
            cardObserver.observe(card);
        });
    } else {
        // Fallback for older browsers or if no cards found: make all cards visible immediately
        researchCards.forEach(function(card) {
            card.classList.add('visible');
        });
    }
});
