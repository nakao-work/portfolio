<?php if (!is_front_page() && !is_page('thanks')) { //トップページとサンクスページでは表示しない ?>
  <div class="breadcrumbs">
    <ul>
        <?php if (function_exists('bcn_display')) {
            bcn_display_list();
        } ?>
    </ul>
  </div>
<?php } ?>