<?php
defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html lang="he-IL" dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo esc_url(amichai_asset('assets/images/logo.svg')); ?>" type="image/svg+xml">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="am-skip" href="#main">דילוג לתוכן</a>
<header class="am-header">
  <div class="am-wrap am-header-inner">
    <a class="am-logo" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo esc_url(amichai_asset('assets/images/logo.svg')); ?>" width="46" height="46" alt="">
      <span>עמיחי מרקס</span>
    </a>
    <button class="am-nav-toggle" type="button" aria-expanded="false" aria-controls="am-nav">תפריט</button>
    <nav id="am-nav" class="am-nav" aria-label="ראשי">
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'am-menu',
          'fallback_cb' => 'amichai_fallback_menu',
      ]);
      ?>
    </nav>
    <a class="am-header-phone" href="tel:054-2372417">
      <span class="am-header-phone-num">054-2372417</span>
      <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path fill="currentColor" d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.4 11.4 0 0 0 .57 3.6 1 1 0 0 1-.25 1L6.6 10.8z"/></svg>
    </a>
  </div>
</header>
