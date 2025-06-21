<footer>
    <div class="top-footer-logo">
      <a href="<?php echo home_url(); ?>"><img class="footer-logo-image" src="<?php echo get_template_directory_uri() ?>/images/mono_logo.png"></a>
      <div><small>© 2023 orange All Rights Reserved.</small></div>
    </div>
    <?php
    wp_nav_menu(
      array(
        'theme_location' => 'footer'
      )
    ); ?>
</footer>
  <?php wp_footer(); ?>
</body>
</html>


