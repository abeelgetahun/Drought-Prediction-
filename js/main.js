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
});
