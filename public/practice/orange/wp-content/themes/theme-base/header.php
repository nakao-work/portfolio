<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body>
  <header>
    <div class="hamburger-container">
      <p class="btn-hamburger">
        <span></span>
        <span></span>
        <span></span>
      </p>
    </div>
    <?php
    wp_nav_menu(
      array(
        'theme_location' => 'header'
      )
    ); ?>
    <div class="menu-menu1-bg"></div>

    <div class="top-header-logo">
      <a href="<?php echo home_url(); ?>"><img class="header-logo-image" src="<?php echo get_template_directory_uri() ?>/images/logo.png"></a>
    </div>

    <div class="top-header-reserve">
      <a class="btn-reserve" href="https://beauty.hotpepper.jp/">ご予約はこちら</a>
    </div>
  </header>