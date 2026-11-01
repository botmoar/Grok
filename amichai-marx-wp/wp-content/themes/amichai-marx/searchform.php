<?php defined('ABSPATH') || exit; ?>
<form role="search" method="get" class="am-form" action="<?php echo esc_url(home_url('/')); ?>">
  <label>חיפוש באתר
    <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="למשל: משכנתא, פנסיה, מינוס">
  </label>
  <button class="am-btn am-btn-primary" type="submit">חיפוש</button>
</form>
