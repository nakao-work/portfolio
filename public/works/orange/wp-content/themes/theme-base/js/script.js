// スクロールでふわっと表示する
jQuery(function(){
  jQuery(window).scroll(function (){
      jQuery('.fadein').each(function(){
          var targetElement = jQuery(this).offset().top;
          var scroll = jQuery(window).scrollTop();
          var windowHeight = jQuery(window).height();
          if (scroll > targetElement - windowHeight + 200){
              if(jQuery('.fadein-left')) {
                jQuery(this).css('opacity','1');
                jQuery(this).css('transform','translateX(0)');
              };
              if(jQuery('.fadein-right')) {
                jQuery(this).css('opacity','1');
                jQuery(this).css('transform','translateX(0)');
              };
              if(jQuery('.fadein-bottom')) {
                jQuery(this).css('opacity','1');
                jQuery(this).css('transform','translateY(0)');
              };
          }
      });
  });
});



// ハンバーガーメニュー
jQuery(function() {
  var leftVal;

  // ハンバーガーメニューを開くときの設定
  function hamburgerOpen() {
    // メニューの位置を開いた状態にする
    leftVal = 0;

    // メニューを開いた状態になるよう設定
    jQuery(".btn-hamburger").addClass("open");

    // 背景コンテンツのスクロールを固定
    jQuery("body").css("overflow", "hidden");
    jQuery(".menu-menu1-container").css("overflow", "scroll");
  }

  // ハンバーガーメニューを閉じる時の設定
  function hamburgerClose() {
    // メニューを閉じた状態にする
    leftVal = -300;

    // メニューを閉じた状態になるよう設定
    jQuery(".btn-hamburger").removeClass("open");

    // 背景コンテンツのスクロールを固定を解除
    jQuery("body").css("overflow", "auto");
    jQuery(".menu-menu1-container").css("overflow", "auto");
    jQuery(".menu-menu1-container").scrollTop(0);
  }

  // ハンバーガーメニューを開閉する処理
  function hamburgerToggle() {
    jQuery(".menu-menu1-container").stop().animate( {
      left: leftVal
    }, 200);
    jQuery(".menu-menu1-bg").fadeToggle(200);
  }

  // ハンバーガーのボタンをクリックした時の処理
  jQuery('.btn-hamburger').on("click", function() {
    // ハンバーガーのボタンに対する処理
    if(jQuery(".btn-hamburger").hasClass("open")) {
      hamburgerClose();
    } else {
      hamburgerOpen();
    }
    hamburgerToggle();
  });

  //　背景をクリックした時の処理
  jQuery('.menu-menu1-bg').on("click", function() {
    hamburgerClose();
    hamburgerToggle();
  });

  // メニューのリンクをクリックした時の処理
  jQuery('.menu-menu1-container a').on("click", function() {
    if (window.matchMedia('(max-width: 1024px)').matches) {
      hamburgerClose();
      hamburgerToggle();
      console.log('ddd');
    };
  });

});
