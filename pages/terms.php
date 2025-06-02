<?php 
$pageTitle = "DroughtWatch - Terms of Use";
$pageDescription = "Terms of use and legal information for DroughtWatch services and platform.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="terms-container">
                <h1 class="page-title text-center mb-4">Terms of Use</h1>
                <p class="text-center text-muted mb-5">Last updated: <?php echo date('F j, Y'); ?></p>
                
                <div class="terms-content">
                    <section class="terms-section">
                        <h2>1. Acceptance of Terms</h2>
                        <p>By accessing and using DroughtWatch ("the Service"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                    </section>
                    
                    <section class="terms-section">
                        <h2>2. Description of Service</h2>
                        <p>DroughtWatch provides drought monitoring and prediction services through:</p>
                        <ul>
                            <li>Real-time drought condition monitoring</li>
                            <li>Predictive analytics and forecasting</li>
                            <li>Research data and publications</li>
                            <li>Educational resources and tools</li>
                            <li>Community collaboration platforms</li>
                        </ul>
                    </section>
                    
                    <section class="terms-section">
                        <h2>3. User Responsibilities</h2>
                        <p>Users of DroughtWatch agree to:</p>
                        <ul>
                            <li>Provide accurate and complete information when required</li>
                            <li>Use the service for lawful purposes only</li>
                            <li>Respect intellectual property rights</li>
                            <li>Not attempt to gain unauthorized access to our systems</li>
                            <li>Report any security vulnerabilities responsibly</li>
                        </ul>
                    </section>
                    
                    <section class="terms-section">
                        <h2>4. Data Usage and Privacy</h2>
                        <p>DroughtWatch is committed to protecting your privacy. Our data practices include:</p>
                        <ul>
                            <li>Collection of minimal necessary information</li>
                            <li>Secure storage and transmission of data</li>
                            <li>No sale of personal information to third parties</li>
                            <li>Transparent data usage policies</li>
                            <li>User control over personal data</li>
                        </ul>
                        <p>For detailed information, please review our <a href="privacy.php">Privacy Policy</a>.</p>
                    </section>
                    
                    <section class="terms-section">
                        <h2>5. Intellectual Property</h2>
                        <p>All content, data, and materials provided through DroughtWatch are protected by intellectual property laws. Users may:</p>
                        <ul>
                            <li>Access and use data for research and educational purposes</li>
                            <li>Cite DroughtWatch as the source when using our data</li>
                            <li>Share information with proper attribution</li>
                        </ul>
                        <p>Commercial use requires explicit permission from DroughtWatch.</p>
                    </section>
                    
                    <section class="terms-section">
                        <h2>6. Disclaimer of Warranties</h2>
                        <p>DroughtWatch provides information and services "as is" without warranties of any kind. While we strive for accuracy, we cannot guarantee:</p>
                        <ul>
                            <li>Complete accuracy of all data and predictions</li>
                            <li>Uninterrupted service availability</li>
                            <li>Fitness for any particular purpose</li>
                            <li>Error-free operation</li>
                        </ul>
                    </section>
                    
                    <section class="terms-section">
                        <h2>7. Limitation of Liability</h2>
                        <p>DroughtWatch shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from the use or inability to use our services, even if we have been advised of the possibility of such damages.</p>
                    </section>
                    
                    <section class="terms-section">
                        <h2>8. Modifications to Terms</h2>
                        <p>DroughtWatch reserves the right to modify these terms at any time. Users will be notified of significant changes through:</p>
                        <ul>
                            <li>Email notifications to registered users</li>
                            <li>Prominent notices on our website</li>
                            <li>Updates to this page with revision dates</li>
                        </ul>
                    </section>
                    
                    <section class="terms-section">
                        <h2>9. Contact Information</h2>
                        <p>For questions about these Terms of Use, please contact us:</p>
                        <div class="contact-info">
                            <p><strong>Email:</strong> legal@droughtwatch.org</p>
                            <p><strong>Address:</strong> DroughtWatch Legal Department<br>
                            123 Research Park Drive<br>
                            Science City, SC 90210</p>
                        </div>
                    </section>
                </div>
                
                <div class="terms-footer">
                    <p class="text-center">
                        <a href="../pages/contact.php" class="btn btn-primary me-3">Contact Us</a>
                        <a href="../pages/privacy.php" class="btn btn-outline-primary">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Terms Page Styles */
.page-title {
    color: var(--current-text);
    font-weight: 700;
}

.terms-container {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 3rem;
    box-shadow: var(--shadow-sm);
    margin-bottom: 3rem;
}

.terms-content {
    line-height: 1.7;
    color: var(--current-text-secondary);
}

.terms-section {
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--current-bg-secondary);
}

.terms-section:last-child {
    border-bottom: none;
    margin-bottom: 2rem;
}

.terms-section h2 {
    color: var(--current-text);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.terms-section ul {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.terms-section li {
    margin-bottom: 0.5rem;
}

.terms-section a {
    color: var(--current-accent);
    text-decoration: none;
}

.terms-section a:hover {
    text-decoration: underline;
}

.contact-info {
    background: var(--current-bg-secondary);
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.contact-info p {
    margin-bottom: 0.5rem;
}

.contact-info p:last-child {
    margin-bottom: 0;
}

.terms-footer {
    border-top: 2px solid var(--current-accent);
    padding-top: 2rem;
    margin-top: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .terms-container {
        padding: 2rem 1.5rem;
    }
    
    .terms-section h2 {
        font-size: 1.3rem;
    }
}
</style>

<?php include '../includes/footer.php'; ?>