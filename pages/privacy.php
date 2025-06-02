<?php 
$pageTitle = "DroughtWatch - Privacy Policy";
$pageDescription = "Learn how DroughtWatch protects your privacy and handles your personal information.";
$basePath = '../';
$cssPath = '../';
include '../includes/header.php';
?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="privacy-container">
                <div class="privacy-header text-center mb-5">
                    <h1 class="page-title">Privacy Policy</h1>
                    <p class="lead">Your privacy is important to us. This policy explains how we collect, use, and protect your information.</p>
                    <div class="last-updated">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Last updated: <?php echo date('F j, Y'); ?>
                    </div>
                </div>
                
                <!-- Privacy Summary Cards -->
                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="privacy-highlight">
                            <div class="highlight-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>Data Protection</h4>
                            <p>We use industry-standard security measures to protect your personal information.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="privacy-highlight">
                            <div class="highlight-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h4>Your Control</h4>
                            <p>You have full control over your data and can request access, updates, or deletion at any time.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="privacy-highlight">
                            <div class="highlight-icon">
                                <i class="fas fa-ban"></i>
                            </div>
                            <h4>No Sale</h4>
                            <p>We never sell your personal information to third parties or use it for unauthorized purposes.</p>
                        </div>
                    </div>
                </div>

                <!-- Table of Contents -->
                <div class="privacy-toc mb-4">
                    <h3>Table of Contents</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="toc-list">
                                <li><a href="#information-collection">1. Information We Collect</a></li>
                                <li><a href="#information-use">2. How We Use Information</a></li>
                                <li><a href="#information-sharing">3. Information Sharing</a></li>
                                <li><a href="#data-security">4. Data Security</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="toc-list">
                                <li><a href="#your-rights">5. Your Rights</a></li>
                                <li><a href="#cookies">6. Cookies and Tracking</a></li>
                                <li><a href="#policy-changes">7. Policy Changes</a></li>
                                <li><a href="#contact-privacy">8. Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="privacy-content">
                    <section class="privacy-section" id="information-collection">
                        <h2><span class="section-number">1.</span> Information We Collect</h2>
                        <div class="section-content">
                            <h4>Personal Information</h4>
                            <p>We may collect the following types of personal information:</p>
                            <ul>
                                <li><strong>Contact Information:</strong> Name, email address, phone number, and mailing address</li>
                                <li><strong>Professional Information:</strong> Organization, job title, research interests</li>
                                <li><strong>Account Information:</strong> Username, password, and profile preferences</li>
                                <li><strong>Communication Data:</strong> Messages, feedback, and support requests</li>
                            </ul>
                            
                            <h4>Automatically Collected Information</h4>
                            <ul>
                                <li><strong>Usage Data:</strong> Pages visited, time spent, click patterns</li>
                                <li><strong>Device Information:</strong> IP address, browser type, operating system</li>
                                <li><strong>Location Data:</strong> General geographic location (country/region level)</li>
                            </ul>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="information-use">
                        <h2><span class="section-number">2.</span> How We Use Information</h2>
                        <div class="section-content">
                            <p>We use your information for the following purposes:</p>
                            <div class="use-cases">
                                <div class="use-case">
                                    <i class="fas fa-cog"></i>
                                    <div>
                                        <h5>Service Provision</h5>
                                        <p>To provide, maintain, and improve our drought monitoring services</p>
                                    </div>
                                </div>
                                <div class="use-case">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <h5>Communication</h5>
                                        <p>To send updates, newsletters, and respond to your inquiries</p>
                                    </div>
                                </div>
                                <div class="use-case">
                                    <i class="fas fa-chart-bar"></i>
                                    <div>
                                        <h5>Analytics</h5>
                                        <p>To understand usage patterns and improve user experience</p>
                                    </div>
                                </div>
                                <div class="use-case">
                                    <i class="fas fa-shield-alt"></i>
                                    <div>
                                        <h5>Security</h5>
                                        <p>To protect against fraud, abuse, and security threats</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="information-sharing">
                        <h2><span class="section-number">3.</span> Information Sharing</h2>
                        <div class="section-content">
                            <p>We may share your information in the following limited circumstances:</p>
                            <ul>
                                <li><strong>Research Partners:</strong> Anonymized data for collaborative research projects</li>
                                <li><strong>Service Providers:</strong> Third-party services that help us operate our platform</li>
                                <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                                <li><strong>Business Transfers:</strong> In case of merger, acquisition, or asset sale</li>
                            </ul>
                            <div class="important-note">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p><strong>Important:</strong> We never sell your personal information to advertisers or marketing companies.</p>
                            </div>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="data-security">
                        <h2><span class="section-number">4.</span> Data Security</h2>
                        <div class="section-content">
                            <p>We implement comprehensive security measures to protect your information:</p>
                            <div class="security-measures">
                                <div class="security-item">
                                    <i class="fas fa-lock"></i>
                                    <span>SSL/TLS encryption for data transmission</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-database"></i>
                                    <span>Encrypted data storage and regular backups</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Access controls and employee training</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-search"></i>
                                    <span>Regular security audits and monitoring</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="your-rights">
                        <h2><span class="section-number">5.</span> Your Rights</h2>
                        <div class="section-content">
                            <p>You have the following rights regarding your personal information:</p>
                            <div class="rights-grid">
                                <div class="right-item">
                                    <h5>Access</h5>
                                    <p>Request a copy of your personal data</p>
                                </div>
                                <div class="right-item">
                                    <h5>Correction</h5>
                                    <p>Update or correct inaccurate information</p>
                                </div>
                                <div class="right-item">
                                    <h5>Deletion</h5>
                                    <p>Request deletion of your personal data</p>
                                </div>
                                <div class="right-item">
                                    <h5>Portability</h5>
                                    <p>Export your data in a readable format</p>
                                </div>
                            </div>
                            <p class="mt-3">To exercise these rights, please contact us at <a href="mailto:privacy@droughtwatch.org">privacy@droughtwatch.org</a></p>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="cookies">
                        <h2><span class="section-number">6.</span> Cookies and Tracking</h2>
                        <div class="section-content">
                            <p>We use cookies and similar technologies to enhance your experience:</p>
                            <div class="cookie-types">
                                <div class="cookie-type">
                                    <h5>Essential Cookies</h5>
                                    <p>Required for basic site functionality and security</p>
                                    <span class="cookie-status required">Required</span>
                                </div>
                                <div class="cookie-type">
                                    <h5>Analytics Cookies</h5>
                                    <p>Help us understand how visitors use our site</p>
                                    <span class="cookie-status optional">Optional</span>
                                </div>
                                <div class="cookie-type">
                                    <h5>Preference Cookies</h5>
                                    <p>Remember your settings and preferences</p>
                                    <span class="cookie-status optional">Optional</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="policy-changes">
                        <h2><span class="section-number">7.</span> Policy Changes</h2>
                        <div class="section-content">
                            <p>We may update this privacy policy from time to time. When we do:</p>
                            <ul>
                                <li>We'll notify you via email if you have an account with us</li>
                                <li>We'll post a notice on our website</li>
                                <li>We'll update the "Last updated" date at the top of this policy</li>
                                <li>Significant changes will be highlighted for 30 days</li>
                            </ul>
                        </div>
                    </section>
                    
                    <section class="privacy-section" id="contact-privacy">
                        <h2><span class="section-number">8.</span> Contact Us</h2>
                        <div class="section-content">
                            <p>If you have questions about this privacy policy or our data practices, please contact us:</p>
                            <div class="contact-methods">
                                <div class="contact-method">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <strong>Email:</strong>
                                        <a href="mailto:privacy@droughtwatch.org">privacy@droughtwatch.org</a>
                                    </div>
                                </div>
                                <div class="contact-method">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <strong>Address:</strong>
                                        DroughtWatch Privacy Office<br>
                                        123 Research Park Drive<br>
                                        Science City, SC 90210
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
                <div class="privacy-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="../pages/terms.php" class="btn btn-outline-primary">Terms of Use</a>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="../pages/contact.php" class="btn btn-primary">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Privacy Policy Styles */
.page-title {
    color: var(--current-text);
    font-weight: 700;
    margin-bottom: 1rem;
}

.privacy-container {
    background: var(--current-bg);
    border-radius: 12px;
    padding: 3rem;
    box-shadow: var(--shadow-sm);
    margin-bottom: 3rem;
}

.last-updated {
    background: var(--current-bg-secondary);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    color: var(--current-text-muted);
    font-size: 0.9rem;
    display: inline-block;
}

.privacy-highlight {
    background: var(--current-bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    height: 100%;
    transition: all 0.3s ease;
}

.privacy-highlight:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.highlight-icon {
    width: 60px;
    height: 60px;
    background: var(--current-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.highlight-icon i {
    font-size: 1.5rem;
    color: var(--current-bg);
}

.privacy-highlight h4 {
    color: var(--current-text);
    margin-bottom: 1rem;
    font-weight: 600;
}

.privacy-toc {
    background: var(--current-bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.privacy-toc h3 {
    color: var(--current-text);
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.toc-list {
    list-style: none;
    padding: 0;
}

.toc-list li {
    margin-bottom: 0.75rem;
}

.toc-list a {
    color: var(--current-text-secondary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.toc-list a:hover {
    color: var(--current-accent);
}

.privacy-content {
    line-height: 1.7;
    color: var(--current-text-secondary);
}

.privacy-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--current-bg-secondary);
}

.privacy-section:last-child {
    border-bottom: none;
    margin-bottom: 2rem;
}

.privacy-section h2 {
    color: var(--current-text);
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
}

.section-number {
    color: var(--current-accent);
    font-weight: 700;
}

.section-content h4, .section-content h5 {
    color: var(--current-text);
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.use-cases {
    display: grid;
    gap: 1.5rem;
    margin: 2rem 0;
}

.use-case {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--current-bg-secondary);
    border-radius: 8px;
}

.use-case i {
    color: var(--current-accent);
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.use-case h5 {
    margin: 0 0 0.5rem 0;
    color: var(--current-text);
}

.use-case p {
    margin: 0;
}

.important-note {
    background: linear-gradient(135deg, var(--current-accent), #ffb700);
    color: var(--current-bg);
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.important-note i {
    font-size: 1.5rem;
}

.security-measures {
    display: grid;
    gap: 1rem;
    margin: 2rem 0;
}

.security-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--current-bg-secondary);
    border-radius: 8px;
}

.security-item i {
    color: var(--current-accent);
    font-size: 1.25rem;
}

.rights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.right-item {
    padding: 1.5rem;
    background: var(--current-bg-secondary);
    border-radius: 8px;
    text-align: center;
}

.right-item h5 {
    color: var(--current-text);
    margin-bottom: 0.5rem;
}

.cookie-types {
    display: grid;
    gap: 1.5rem;
    margin: 2rem 0;
}

.cookie-type {
    padding: 1.5rem;
    background: var(--current-bg-secondary);
    border-radius: 8px;
    position: relative;
}

.cookie-type h5 {
    color: var(--current-text);
    margin-bottom: 0.5rem;
}

.cookie-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.cookie-status.required {
    background: var(--current-accent);
    color: var(--current-bg);
}

.cookie-status.optional {
    background: var(--current-bg-tertiary);
    color: var(--current-text-muted);
}

.contact-methods {
    display: grid;
    gap: 1.5rem;
    margin: 2rem 0;
}

.contact-method {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--current-bg-secondary);
    border-radius: 8px;
}

.contact-method i {
    color: var(--current-accent);
    font-size: 1.25rem;
    margin-top: 0.25rem;
}

.contact-method a {
    color: var(--current-accent);
    text-decoration: none;
}

.contact-method a:hover {
    text-decoration: underline;
}

.privacy-footer {
    border-top: 2px solid var(--current-accent);
    padding-top: 2rem;
    margin-top: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .privacy-container {
        padding: 2rem 1.5rem;
    }
    
    .privacy-section h2 {
        font-size: 1.5rem;
    }
    
    .use-cases {
        grid-template-columns: 1fr;
    }
    
    .rights-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include '../includes/footer.php'; ?>