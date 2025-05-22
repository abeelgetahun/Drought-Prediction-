document.addEventListener('DOMContentLoaded', function() {
    const lazyImages = document.querySelectorAll('img.lazy-load-image');

    if ('IntersectionObserver' in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    
                    lazyImage.onload = () => {
                        lazyImage.classList.remove('lazy-load-image'); // Remove class to stop spinner
                        lazyImage.classList.remove('loading');
                        lazyImage.classList.add('loaded');
                    };
                    lazyImage.onerror = () => {
                        lazyImage.classList.remove('lazy-load-image'); // Stop spinner
                        lazyImage.classList.remove('loading');
                        lazyImage.classList.add('error');
                        // Optionally set a fallback image, e.g.:
                        // lazyImage.src = 'images/fallback-placeholder.png'; 
                        // Ensure fallback-placeholder.png exists if you use this.
                        // For now, it will just show the alt text or broken image icon.
                    };
                    observer.unobserve(lazyImage);
                }
            });
        }, { rootMargin: "0px 0px 100px 0px" }); // Start loading images 100px before they enter viewport

        lazyImages.forEach(function(lazyImage) {
            lazyImage.classList.add('loading'); // Add a class to style the loading state
            lazyImageObserver.observe(lazyImage);
        });
    } else {
        // Fallback for older browsers
        lazyImages.forEach(function(lazyImage) {
            lazyImage.src = lazyImage.dataset.src;
            lazyImage.onload = () => {
                lazyImage.classList.remove('lazy-load-image');
                lazyImage.classList.remove('loading');
                lazyImage.classList.add('loaded');
            };
            lazyImage.onerror = () => {
                lazyImage.classList.remove('lazy-load-image');
                lazyImage.classList.remove('loading');
                lazyImage.classList.add('error');
            };
        });
    }
});
