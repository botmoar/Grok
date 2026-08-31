</main>
<footer class="site-footer" role="contentinfo">
    <div class="footer-grid">
        <div class="footer-col">
            <h3>יצירת קשר</h3>
            <a href="tel:<?php echo esc_attr(AHAVAT_PHONE_TEL); ?>">
                <img src="<?php echo esc_url(ahavat_img('icon_phone')); ?>" alt="" width="18" height="18" />
                <?php echo esc_html(AHAVAT_PHONE_DISPLAY); ?>
            </a>
            <a href="tel:<?php echo esc_attr(AHAVAT_PHONE_TEL); ?>">
                <img src="<?php echo esc_url(ahavat_img('icon_fax')); ?>" alt="" width="18" height="18" />
                <?php echo esc_html(AHAVAT_PHONE_DISPLAY); ?>
            </a>
            <a href="<?php echo esc_url(ahavat_whatsapp_url()); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(ahavat_img('icon_whatsapp')); ?>" alt="" width="18" height="18" />
                <?php echo esc_html(AHAVAT_WHATSAPP_DISPLAY); ?>
            </a>
            <a href="mailto:<?php echo esc_attr(AHAVAT_EMAIL_VET); ?>">
                <img src="<?php echo esc_url(ahavat_img('icon_mail')); ?>" alt="" width="18" height="18" />
                <?php echo esc_html(AHAVAT_EMAIL_VET); ?>
            </a>
        </div>
        <div class="footer-col">
            <h3>שעות פתיחה</h3>
            <p class="footer-hours"><span>ימים א -ה</span> <strong>08:30 - 19:00</strong></p>
            <p class="footer-hours"><span>ימי ו׳ וערבי חג</span> <strong>08:30 - 13:30</strong></p>
            <div class="footer-emergency">
                <img src="<?php echo esc_url(ahavat_img('icon_ambulance')); ?>" alt="" width="36" height="36" />
                <div>
                    <p><strong>חירום</strong> החל מ 19:00</p>
                    <a href="tel:<?php echo esc_attr(AHAVAT_EMERGENCY_TEL); ?>"><?php echo esc_html(AHAVAT_EMERGENCY_DISPLAY); ?></a>
                </div>
            </div>
        </div>
        <div class="footer-col footer-col--brand">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img class="footer-logo" src="<?php echo esc_url(ahavat_img('logo_footer') ?: ahavat_img('logo')); ?>" alt="אהבת החי" width="180" height="70" />
            </a>
            <a href="<?php echo esc_url(AHAVAT_MAPS); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(ahavat_img('icon_pin')); ?>" alt="" width="18" height="18" />
                יד המעביר 9 הדר יוסף תל אביב
            </a>
            <a href="<?php echo esc_url(AHAVAT_FB); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(ahavat_img('icon_facebook')); ?>" alt="" width="18" height="18" />
                Facebook
            </a>
            <a href="<?php echo esc_url(AHAVAT_IG); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(ahavat_img('icon_instagram')); ?>" alt="" width="18" height="18" />
                Instagram
            </a>
            <p class="footer-friends">בואו נהיה חברים!</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
