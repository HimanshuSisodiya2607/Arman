    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <a href="<?php echo isset($base) ? $base : ''; ?>index.html" class="footer-logo">
                        <img src="<?php echo isset($base) ? $base : ''; ?>logo.jpg" alt="VocalFluxStudio" style="width: 40px; height: 40px; border-radius: 8px;">
                        <span>VocalFlux<span class="accent">Studio</span></span>
                    </a>
                    <p>The world's first fully secure, no-contact dubbing & voiceover production platform. Voice. Secure. Delivered.</p>
                </div>
                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="<?php echo isset($base) ? $base : ''; ?>index.html">Home</a></li>
                        <li><a href="<?php echo isset($base) ? $base : ''; ?>index.php">Links</a></li>
                        <li><a href="<?php echo isset($base) ? $base : ''; ?>admin/login.php">Admin</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="mailto:vocalfluxstudio@gmail.com">vocalfluxstudio@gmail.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025 VocalFluxStudio Inc. All rights reserved.</p>
                <p>Secured with AES-256 Encryption</p>
            </div>
        </div>
    </footer>
    <script src="<?php echo isset($base) ? $base : ''; ?>script.js"></script>
    <?php if (!empty($extra_js)) { echo $extra_js; } ?>
</body>
</html>
