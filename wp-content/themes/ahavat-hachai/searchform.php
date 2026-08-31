<form class="search-form" action="<?php echo esc_url(home_url('/search/')); ?>" method="get" role="search">
    <label class="visually-hidden" for="s">חפש</label>
    <input id="s" type="search" name="s" placeholder="חפש שאלה..." value="<?php echo esc_attr(get_search_query()); ?>" />
    <button class="btn btn--pink" type="submit">חפש</button>
</form>
