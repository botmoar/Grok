<?php
defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html lang="he-IL" dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo esc_url(amichai_asset('assets/images/logo-mark.png')); ?>" type="image/png">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="am-skip" href="#main">דילוג לתוכן</a>
<header class="am-header">
  <div class="am-wrap am-header-inner">
    <a class="am-logo" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo esc_url(amichai_asset('assets/images/logo.png')); ?>" width="492" height="120" alt="עמיחי מרקס, יועץ ומאמן לכלכלת המשפחה">
    </a>
    <button class="am-nav-toggle" type="button" aria-expanded="false" aria-controls="am-nav" aria-label="פתיחת תפריט">
      <span class="am-burger" aria-hidden="true"></span>
    </button>
    <nav id="am-nav" class="am-nav" aria-label="ראשי">
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'am-menu',
          'depth' => 2,
          'fallback_cb' => 'amichai_fallback_menu',
      ]);
      ?>
    </nav>
    <a class="am-header-phone" href="tel:054-2372417" aria-label="חייגו 054-2372417">
      <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      <span class="am-header-phone-num">054-2372417</span>
    </a>
  </div>
</header>
<div class="am-nav-backdrop" hidden></div>
