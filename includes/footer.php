<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="footer-brand">
                    <h5 class="footer-title">DroughtWatch</h5>
                    <p class="footer-description">A leading platform dedicated to monitoring and analyzing drought conditions in Ethiopia. We provide data-driven insights to help communities, researchers, and policymakers respond effectively to drought challenges.</p>
                    <div class="footer-cta">
                        <a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/about.php" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-info-circle me-1"></i>
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                <h5 class="footer-title">Navigation</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>index.php" class="footer-link">
                        <i class="fas fa-home me-1"></i>Home
                    </a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/researchers.php" class="footer-link">
                        <i class="fas fa-microscope me-1"></i>Research
                    </a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/news.php" class="footer-link">
                        <i class="fas fa-newspaper me-1"></i>News
                    </a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/events.php" class="footer-link">
                        <i class="fas fa-calendar me-1"></i>Events
                    </a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/stories.php" class="footer-link">
                        <i class="fas fa-book-open me-1"></i>Stories
                    </a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="footer-title">Resources</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/thematic_focus.php" class="footer-link">
                        <i class="fas fa-bullseye me-1"></i>Thematic Focus
                    </a></li>
                 
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/contact.php" class="footer-link">
                        <i class="fas fa-envelope me-1"></i>Contact Us
                    </a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/privacy.php" class="footer-link">
                        <i class="fas fa-shield-alt me-1"></i>Privacy Policy
                    </a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/terms.php" class="footer-link">
                        <i class="fas fa-gavel me-1"></i>Terms of Use
                    </a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">Connect & Subscribe</h5>
                
                <!-- Social Media Links -->
                <div class="social-section mb-4">
                    <p class="social-label">Follow us on social media:</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon" aria-label="Facebook" title="Follow us on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Twitter" title="Follow us on Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="LinkedIn" title="Connect on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="YouTube" title="Subscribe to our YouTube channel">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Instagram" title="Follow us on Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Newsletter Subscription -->
                <div class="newsletter-section">
                    <p class="newsletter-label">Subscribe to our newsletter:</p>
                    <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
                        <div class="input-group">
                            <input type="email" class="form-control newsletter-input" 
                                   placeholder="Enter your email" 
                                   aria-label="Email address for newsletter"
                                   required>
                            <button class="btn btn-primary newsletter-btn" type="submit">
                                <i class="fas fa-paper-plane"></i>
                                <span class="btn-text">Subscribe</span>
                            </button>
                        </div>
                        <small class="newsletter-note">Get the latest drought research updates and news.</small>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <hr class="footer-divider">
        <div class="row footer-bottom">
            <div class="col-md-6">
                <p class="copyright">
                    &copy; <?php echo date("Y"); ?> DroughtWatch. All Rights Reserved.
                </p>
            </div>
            <div class="col-md-6">
                <div class="footer-bottom-links">
                    <a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/privacy.php" class="footer-bottom-link">Privacy</a>
                    <span class="separator">|</span>
                    <a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/terms.php" class="footer-bottom-link">Terms</a>
                    <span class="separator">|</span>
                    <a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/contact.php" class="footer-bottom-link">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* Enhanced Footer Styles */
.footer {
    background: linear-gradient(135deg, var(--current-bg-secondary), var(--current-bg-tertiary));
    color: var(--current-text);
    padding: 3rem 0 1rem;
    margin-top: 4rem;
    border-top: 3px solid var(--current-accent);
}

.footer-brand {
    margin-bottom: 1rem;
}

.footer-title {
    color: var(--current-text);
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.25rem;
    position: relative;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 30px;
    height: 2px;
    background: var(--current-accent);
}

.footer-description {
    color: var(--current-text-secondary);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.footer-cta {
    margin-top: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-link {
    color: var(--current-text-secondary);
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.footer-link:hover {
    color: var(--current-accent);
    transform: translateX(5px);
}

.footer-link i {
    width: 16px;
    font-size: 0.8rem;
}

/* Social Media Section */
.social-section {
    margin-bottom: 2rem;
}

.social-label,
.newsletter-label {
    color: var(--current-text-secondary);
    font-size: 0.9rem;
    margin-bottom: 1rem;
    display: block;
}

.social-icons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.social-icon {
    width: 40px;
    height: 40px;
    background: var(--current-bg);
    color: var(--current-text);
    border: 2px solid var(--current-bg-tertiary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.social-icon:hover {
    background: var(--current-accent);
    color: var(--current-bg);
    border-color: var(--current-accent);
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Newsletter Section */
.newsletter-section {
    background: var(--current-bg);
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid var(--current-bg-tertiary);
}

.newsletter-form .input-group {
    margin-bottom: 0.75rem;
}

.newsletter-input {
    background: var(--current-bg-secondary);
    border: 1px solid var(--current-bg-tertiary);
    color: var(--current-text);
    font-size: 0.9rem;
}

.newsletter-input:focus {
    background: var(--current-bg-secondary);
    border-color: var(--current-accent);
    color: var(--current-text);
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
}

.newsletter-btn {
    background: var(--current-accent);
    border-color: var(--current-accent);
    color: var(--current-bg);
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.newsletter-btn:hover {
    background: #e6c200;
    border-color: #e6c200;
    transform: translateY(-1px);
}

.newsletter-note {
    color: var(--current-text-muted);
    font-size: 0.75rem;
    line-height: 1.4;
}

/* Footer Bottom */
.footer-divider {
    border-color: var(--current-bg-tertiary);
    margin: 2rem 0 1.5rem;
}

.footer-bottom {
    align-items: center;
}

.copyright {
    color: var(--current-text-muted);
    font-size: 0.85rem;
    margin: 0;
}

.footer-bottom-links {
    text-align: right;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.5rem;
}

.footer-bottom-link {
    color: var(--current-text-muted);
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.3s ease;
}

.footer-bottom-link:hover {
    color: var(--current-accent);
}

.separator {
    color: var(--current-text-muted);
    font-size: 0.85rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer {
        padding: 2rem 0 1rem;
    }
    
    .social-icons {
        justify-content: center;
        gap: 0.75rem;
    }
    
    .footer-bottom-links {
        justify-content: center;
        margin-top: 1rem;
    }
    
    .newsletter-btn .btn-text {
        display: none;
    }
    
    .newsletter-btn {
        padding: 0.5rem 0.75rem;
    }
}

@media (max-width: 576px) {
    .social-icon {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
    
    .newsletter-section {
        padding: 1rem;
    }
}
</style>

<script>
// Newsletter subscription handler
function handleNewsletterSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const email = form.querySelector('input[type="email"]').value;
    const button = form.querySelector('.newsletter-btn');
    const originalContent = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span class="btn-text">Subscribing...</span>';
    button.disabled = true;
    
    // Simulate API call (replace with actual implementation)
    setTimeout(() => {
        // Show success state
        button.innerHTML = '<i class="fas fa-check"></i> <span class="btn-text">Subscribed!</span>';
        button.classList.remove('btn-primary');
        button.classList.add('btn-success');
        
        // Reset form
        form.reset();
        
        // Reset button after 3 seconds
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.disabled = false;
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
        }, 3000);
        
        // Show success message (you can customize this)
        showToast('Successfully subscribed to our newsletter!');
    }, 1500);
}

// Toast notification function
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.innerHTML = `<i class="fas fa-check-circle me-2"></i>${message}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--current-accent);
        color: var(--current-bg);
        padding: 1rem 1.5rem;
        border-radius: 8px;
        z-index: 9999;
        animation: slideInToast 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        font-weight: 500;
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOutToast 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Add CSS for toast animations
const toastStyle = document.createElement('style');
toastStyle.textContent = `
@keyframes slideInToast {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOutToast {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
`;
document.head.appendChild(toastStyle);
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo isset($cssPath) ? $cssPath : '../'; ?>assets/js/droughtwatch-app.js"></script>
</body>
</html>