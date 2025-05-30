/**
 * Enhanced Image Shapes Animation
 */
function initImageShapes() {
    const shapes = document.querySelectorAll('.shape');
    
    shapes.forEach((shape, index) => {
        const image = shape.querySelector('.shape-image');
        
        // Add loading animation
        if (image) {
            image.addEventListener('load', function() {
                shape.style.opacity = '1';
                shape.style.transform = 'scale(1)';
            });
            
            // Add error handling
            image.addEventListener('error', function() {
                console.warn(`Failed to load image: ${this.src}`);
                // Fallback to gradient background
                shape.style.background = 'linear-gradient(135deg, var(--current-accent), rgba(255, 215, 0, 0.1))';
                shape.style.opacity = '1';
            });
        }
        
        // Enhanced floating animation with mouse interaction
        shape.addEventListener('mouseenter', function() {
            this.style.animationPlayState = 'paused';
            this.style.transform = `scale(1.1) rotate(${this.style.getPropertyValue('--rotation')})`;
        });
        
        shape.addEventListener('mouseleave', function() {
            this.style.animationPlayState = 'running';
            this.style.transform = `scale(1) rotate(${this.style.getPropertyValue('--rotation')})`;
        });
    });
}

// Add to your main initialization
document.addEventListener('DOMContentLoaded', function() {
    initImageShapes();
});