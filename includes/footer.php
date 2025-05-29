<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5>About DroughtWatch</h5>
                <p class="text-muted small">DroughtWatch is a leading platform dedicated to monitoring and analyzing drought conditions worldwide. We provide data-driven insights to help communities, researchers, and policymakers respond effectively to drought challenges.</p>
                <div class="mt-3">
                    <a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/about.php" class="btn btn-sm btn-outline-light">Learn More</a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                <h5>Quick Links</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>index.php" class="footer-link">Home</a></li>
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/researchers.php" class="footer-link">Research</a></li>
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/news.php" class="footer-link">News</a></li>
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/events.php" class="footer-link">Events</a></li>
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/stories.php" class="footer-link">Stories</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5>Resources</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/thematic_focus.php" class="footer-link">Thematic Focus</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Data Portal</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Publications</a></li>
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/privacy.php" class="footer-link">Privacy Policy</a></li>
                    <li class="mb-2"><a href="<?php echo isset($basePath) ? $basePath : '../'; ?>pages/terms.php" class="footer-link">Terms of Use</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5>Connect With Us</h5>
                <div class="social-icons mb-3">
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                <p class="small mb-1">Subscribe to our newsletter:</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm" placeholder="Your email address" aria-label="Email address">
                        <button class="btn btn-primary btn-sm" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col text-center text-muted small">
                &copy; <?php echo date("Y"); ?> DroughtWatch. All Rights Reserved.
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo isset($cssPath) ? $cssPath : '../'; ?>assets/js/droughtwatch-app.js"></script>
</body>
</html>