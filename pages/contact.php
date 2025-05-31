<?php 
$pageTitle = "DroughtWatch - Contact Us";
$pageDescription = "Get in touch with the DroughtWatch team for questions, collaborations, or support.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';

// Handle form submission
$form_submitted = false;
$form_success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_submitted = true;
    // In a real implementation, you would process the form data here
    $form_success = true;
}
?>

<div class="container mt-5 pt-5">
    <!-- Page Header -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="page-title">Contact Us</h1>
            <p class="lead">Have questions, suggestions, or want to collaborate? We'd love to hear from you.</p>
        </div>
        <div class="col-lg-6">
            <div class="contact-info-cards">
                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <span>info@droughtwatch.org</span>
                </div>
                <div class="info-card">
                    <i class="fas fa-phone"></i>
                    <span>+251 91 2222 333</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8 mb-5">
            <div class="contact-form-container">
                <h3 class="mb-4">Send us a Message</h3>
                
                <?php if ($form_submitted && $form_success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Thank you for your message! We'll get back to you within 24 hours.
                    </div>
                <?php endif; ?>
                
                <form action="contact.php" method="POST" class="contact-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name *</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="organization" name="organization">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <select class="form-control" id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="research">Research Collaboration</option>
                            <option value="data">Data Access Request</option>
                            <option value="technical">Technical Support</option>
                            <option value="media">Media Inquiry</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter">
                        <label class="form-check-label" for="newsletter">
                            Subscribe to our newsletter for drought research updates
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="contact-sidebar">
                <div class="contact-section">
                    <h4>Office Location</h4>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>DroughtWatch Research Center</strong><br>
                            123 Abrhot Library <br>
                            4-Kilo, Addis Ababa<br>
                            Ethiopia
                        </div>
                    </div>
                </div>
                
                <div class="contact-section">
                    <h4>Office Hours</h4>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM<br>
                            <strong>Saturday:</strong> 10:00 AM - 2:00 PM<br>
                            <strong>Sunday:</strong> Closed
                        </div>
                    </div>
                </div>
                
                <div class="contact-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="contact-section">
                    <h4>Quick Links</h4>
                    <ul class="quick-links">
                        <li><a href="../pages/about.php">About Us</a></li>
                        <li><a href="../pages/researchers.php">Our Team</a></li>
                        <li><a href="../pages/news.php">Latest News</a></li>
                        <li><a href="../pages/events.php">Upcoming Events</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Contact Page Styles */
.page-title {
    color: var(--current-text);
    font-weight: 700;
    margin-bottom: 1rem;
}

.contact-info-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-card {
    background: var(--current-bg);
    border: 2px solid var(--current-accent);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.info-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.info-card i {
    font-size: 1.5rem;
    color: var(--current-accent);
    width: 30px;
    text-align: center;
}

.contact-form-container {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
}

.contact-form .form-label {
    color: var(--current-text);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.contact-form .form-control {
    border: 2px solid var(--current-bg-secondary);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    background: var(--current-bg);
    color: var(--current-text);
    transition: all 0.3s ease;
}

.contact-form .form-control:focus {
    border-color: var(--current-accent);
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    background: var(--current-bg);
    color: var(--current-text);
}

.contact-sidebar {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    height: fit-content;
}

.contact-section {
    margin-bottom: 2rem;
}

.contact-section:last-child {
    margin-bottom: 0;
}

.contact-section h4 {
    color: var(--current-text);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--current-accent);
}

.contact-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.contact-item i {
    color: var(--current-accent);
    font-size: 1.2rem;
    margin-top: 0.2rem;
    width: 20px;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 40px;
    height: 40px;
    background: var(--current-accent);
    color: var(--current-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--current-text);
    color: var(--current-bg);
    transform: translateY(-2px);
}

.quick-links {
    list-style: none;
    padding: 0;
}

.quick-links li {
    margin-bottom: 0.5rem;
}

.quick-links a {
    color: var(--current-text-secondary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.quick-links a:hover {
    color: var(--current-accent);
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-info-cards {
        margin-top: 2rem;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>

<?php include '../includes/footer.php'; ?>