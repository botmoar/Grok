<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?php echo esc_url(ahavat_img('favicon')); ?>" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="<?php echo esc_url(ahavat_img('webclip')); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class('site-rtl'); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content">דלג לתוכן</a>
<header class="site-header" role="banner">
    <div class="header-stripe">
        <div class="header-stripe__inner">
            <a class="header-stripe__address" href="<?php echo esc_url(AHAVAT_MAPS); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(ahavat_img('icon_pin')); ?>" alt="" width="16" height="16" />
                <span><?php echo esc_html(AHAVAT_ADDRESS); ?></span>
            </a>
            <a class="header-stripe__emergency" href="tel:<?php echo esc_attr(AHAVAT_EMERGENCY_TEL); ?>">
                <span>חירום אחרי שעות המרפאה</span>
                <img src="<?php echo esc_url(ahavat_img('icon_ambulance')); ?>" alt="" width="22" height="22" />
                <strong><?php echo esc_html(AHAVAT_EMERGENCY_DISPLAY); ?></strong>
            </a>
        </div>
    </div>
    <div class="header-main">
        <div class="header-main__inner">
            <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(ahavat_img('logo')); ?>" alt="אהבת החי מרכז וטרינרי" width="175" height="41" />
            </a>
            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="תפריט">
                <span></span><span></span><span></span>
            </button>
            <nav id="site-nav" class="site-nav" role="navigation" aria-label="ראשי">
                <a class="<?php echo esc_attr(ahavat_nav_class('/')); ?>" href="<?php echo esc_url(home_url('/')); ?>">דף הבית</a>
                <a class="<?php echo esc_attr(ahavat_nav_class('our-team')); ?>" href="<?php echo esc_url(home_url('/our-team/')); ?>">הצוות</a>
                <a class="<?php echo esc_attr(ahavat_nav_class('our-clinic')); ?>" href="<?php echo esc_url(home_url('/our-clinic/')); ?>">המרפאה</a>
                <a class="<?php echo esc_attr(ahavat_nav_class('grooming')); ?>" href="<?php echo esc_url(home_url('/grooming/')); ?>">המספרה</a>
                <div class="site-nav__dropdown">
                    <button class="site-nav__link site-nav__drop-toggle" type="button" aria-expanded="false" aria-haspopup="true" aria-controls="services-menu" id="services-menu-btn">
                        עוד על השירותים שלנו
                        <span class="chevron" aria-hidden="true"></span>
                    </button>
                    <nav id="services-menu" class="site-nav__drop-menu" aria-labelledby="services-menu-btn">
                        <a href="<?php echo esc_url(home_url('/rpvt-khyvt-qzvtyvt/')); ?>">רפואת חיות אקזוטיות</a>
                        <a href="<?php echo esc_url(home_url('/alternative-treatment/')); ?>">רפואה אלטרנטיבית</a>
                        <a href="<?php echo esc_url(home_url('/dental-treatment/')); ?>">טיפולי שיניים</a>
                    </nav>
                </div>
                <a class="<?php echo esc_attr(ahavat_nav_class('fqa')); ?>" href="<?php echo esc_url(home_url('/fqa/')); ?>">שאלות ותשובות</a>
                <a class="<?php echo esc_attr(ahavat_nav_class('mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym')); ?>" href="<?php echo esc_url(home_url('/mmrym-l-htnhgvt-rnbym-klbym-vkhtvlym/')); ?>">מאמרים</a>
                <a class="site-nav__link" href="<?php echo esc_url(home_url('/#photo-contest')); ?>">תחרות צילום</a>
            </nav>
        </div>
    </div>
    <div class="header-contact">
        <div class="header-contact__inner">
            <a class="header-contact__item" href="<?php echo esc_url(ahavat_whatsapp_url()); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(ahavat_img('icon_whatsapp')); ?>" alt="וואטסאפ" width="20" height="20" />
                <span><?php echo esc_html(AHAVAT_WHATSAPP_DISPLAY); ?></span>
            </a>
            <a class="header-contact__item" href="tel:<?php echo esc_attr(AHAVAT_PHONE_TEL); ?>">
                <img src="<?php echo esc_url(ahavat_img('icon_phone')); ?>" alt="טלפון" width="20" height="20" />
                <span><?php echo esc_html(AHAVAT_PHONE_DISPLAY); ?></span>
            </a>
        </div>
    </div>
    <div class="header-mobile-cta">
        <a class="btn btn--pink btn--icon" href="tel:<?php echo esc_attr(AHAVAT_PHONE_TEL); ?>">
            <img src="<?php echo esc_url(ahavat_img('icon_phone_w')); ?>" alt="" width="18" height="18" />
            <span>דברו איתנו</span>
        </a>
        <a class="btn btn--pink btn--icon" href="<?php echo esc_url(ahavat_whatsapp_url()); ?>">
            <img src="<?php echo esc_url(ahavat_img('icon_whatsapp_w')); ?>" alt="" width="18" height="18" />
            <span>כתבו לנו</span>
        </a>
    </div>
</header>
<main id="content" class="site-main">
