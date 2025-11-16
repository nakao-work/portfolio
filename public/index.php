<?php

// 設定ファイルを読み込み
require_once '../config/const.php';

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nakao's Portfolio | Web Engineer</title>
  <link rel="stylesheet" type="text/css" href="./assets/scss/style.css" />

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-WRKHGH8Z');</script>
  <!-- End Google Tag Manager -->

  <!-- Google recaptcha -->
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>

  <!-- Googleアイコン -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Micromodal -->
  <script src="https://cdn.jsdelivr.net/npm/micromodal@0.4.10/dist/micromodal.min.js"></script>

  <!-- Swiper -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@12.0.3/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12.0.3/swiper-bundle.min.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.23.0/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.23.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WRKHGH8Z"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div class="index-wrapper">
    <header class="header">
      <a href="./index.php" class="header__logo-outer"><img src="./assets/images/logo.png" class="header__logo" alt="ロゴ画像"></a>
      <nav class="header__nav">
        <ul class="header__nav-list">
          <li class="header__nav-item"><a href="#id-about-me" class="header__nav-link">About me</a></li>
          <li class="header__nav-item"><a href="#id-skill" class="header__nav-link">Skill</a></li> 
          <li class="header__nav-item"><a href="#id-works" class="header__nav-link">Works</a></li>
          <li class="header__nav-item"><a href="#id-practice" class="header__nav-link">Practice</a></li>
          <li class="header__nav-item"><a href="#id-profile" class="header__nav-link">Profile</a></li>
        </ul>
      </nav>

      <button id="id-header__btn-hamburger" class="header__btn-hamburger" type="button" aria-controls="id-header__nav" aria-expanded=false aria-label="メニューを開く">
        <span class="header__btn-bar"></span>
      </button>
      <nav id="id-header__hamburger-nav" class="header__hamburger-nav">
        <div id="id-header__hamburger-overlay" class="header__hamburger-overlay"></div>
        <ul id="id-header__hamburger-list" class="header__hamburger-list" aria-hidden="true">
          <li class="header__hamburger-item"><a href="#id-about-me" class="header__nav-link">About me</a></li>
          <li class="header__hamburger-item"><a href="#id-skill" class="header__nav-link">Skill</a></li> 
          <li class="header__hamburger-item"><a href="#id-works" class="header__nav-link">Works</a></li>
          <li class="header__hamburger-item"><a href="#id-practice" class="header__nav-link">Practice</a></li>
          <li class="header__hamburger-item"><a href="#id-profile" class="header__nav-link">Profile</a></li>
        </ul>
      </nav>
    </header>

    <section class="first-view">
      <h1 class="site-title">Nakao's Portfolio</h1>
      <p class="site-sub-title">Web Engineer</p>
      <div class="scroll-announce">
        <!-- <p class="scroll-announce__text">Scroll<br>Down</p> -->
        <span class="material-symbols-rounded">keyboard_double_arrow_down</span>
      </div>
      <div class="icon-container">
        <img src="./assets/images/wheel_unit_pink.png" class="icon-container__icon icon-container__icon--pink icon-container__icon--move">
        <img src="./assets/images/wheel_unit_green.png" class="icon-container__icon icon-container__icon--green icon-container__icon--move">
        <img src="./assets/images/wheel_unit_yellow.png" class="icon-container__icon icon-container__icon--yellow icon-container__icon--move">
      </div>
    </section>

    <section id="id-about-me" class="section about-me">
      <h2 class="section__title">About me</h2>
      <div class="about-me__container">
        <img src="./assets/images/myself.png" style="width: 200px;">
        <p class="about-me__text">はじめまして。平成4年生まれの<span id="myAge"></span>歳。Webエンジニア<span id="elapsedYears"></span>年目の中尾です。<br>
          大学を卒業後造船会社に入社し、5年半設計業務に従事しました。<br>
          その後、造船業界全体の先行きに不安を感じ、29歳で転職をしました。<br>
          現在はwebエンジニアとして業務を担当しております。</p>
      </div>
    </section>

    <section id="id-skill" class="section skill">
      <h2 class="section__title">Skill</h2>
      <p class="score-indicator__text">
        職業訓練校でHTML/CSS、プログラミングスクールでPHPを中心にweb技術を学びました。
        現在の主な業務は、要求定義から社内のデザイナーやプログラマーへのディレクションです。
        また、オフショアの開発会社への開発依頼及び検収作業も行っております。
      </p>
      <p class="score-indicator__text c-mb-30">
        社内向けのシステムなど、自身で開発をする機会もありますが、
        社外向けや一般ユーザー向けの正式なサービスを自身で開発した経験がないため、
        今後プライベートでもいいので、そのような経験を積んでいきたいと考えております。
      </p>
      <div class="skill__container">
        <div class="skill__container-inner">
          <div class="skill__container-item">
            <canvas id="js-chart-frontend" class="chart chart-frontend"></canvas>
          </div>
          <div class="skill__container-item">
            <canvas id="js-chart-backend" class="chart chart-backend"></canvas>
          </div>
          <div class="skill__container-item">
            <canvas id="js-chart-other" class="chart chart-other"></canvas>
          </div>
        </div>
        <div class="score-indicator">
          <h3 class="score-indicator__title">スコア指標</h3>
          <div class="score-indicator__container">
            <p class="score-indicator__item">0 - 今後習得したい技術</p>
            <p class="score-indicator__item">1 - 軽く触ったことがある、または学習中</p>
            <p class="score-indicator__item">2 - 数ヶ月以上使用しているがもう少し習熟が必要</p>
            <p class="score-indicator__item">3 - 実務で基本的な使用が可能</p>
            <p class="score-indicator__item">4 - 応用的な使い方やカスタマイズが可能</p>
            <p class="score-indicator__item">5 - プロフェッショナル</p>
          </div>
        </div>
      </div>
    </section>

    <section id="id-works" class="section works">
      <h2 class="section__title">Works</h2>
      <p class="section__text">これまでに業務で制作した作品を紹介しています。</p>
      <div class="works__container">
        <div class="works__container-item" data-micromodal-trigger="id-modal-1" role="button">
          <img src="./assets/images/works_monitor_clock.png" class="works__container-image">
          <p class="works__container-title">時計サイネージ</p>
          <p class="works__container-subtitle">ショールーム用サイネージ</p>
        </div>
        <div class="modal micromodal-slide" id="id-modal-1" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1">
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
              <header class="modal__header">
                <p class="modal__title" id="id-modal-1-title">モニター時計</p>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
              </header>
              <main class="modal__content" id="id-modal-1-content">
                <div class="modal__content-left">
                  <div class="modal__description">
                    <p>自社のショールームで製品に関する動画を背景に流しながら、時計を表示できるwebアプリを作成しました。ブラウザを全画面表示にしてデジタルサイネージとして使用します。</p>
                    <p>HTML, CSS, JavaScriptのみで構築しており、インターネットやサーバー環境を必要とせず、file:のローカル環境でも動作する仕様になっています。</p>
                    <p>複数の動画ファイルをループ再生する機能については、当初はAjaxでサーバー内の動画を確認する方法を検討しましたが、サーバーを利用しない仕様ではHTTP通信が使えないため、あらかじめ動画の数を定義してループ再生する仕組みに工夫しました。</p>
                  </div>
                  <div class="modal__prog-lang">
                    <p class="modal__prog-lang-title">使用言語</p>
                    <p class="modal__prog-lang-text">HTML/CSS, JavaScript</p>
                  </div>
                </div>
                <div class="modal__content-right">
                  <div class="modal__link-container">
                    <a class="modal__link" href="./works/monitor_clock/" target="_blank">
                      <span>サイトはこちら</span>
                      <span class="material-symbols-rounded">open_in_new</span>
                    </a>
                  </div>
                  <div class="modal__image-container">
                    <a class="modal__image-inner" href="./works/monitor_clock/" target="_blank">
                      <img class="modal__image" src="./assets/images/works_monitor_clock.png">
                    </a>
                  </div>
                  <div class="modal__service">
                    <a href="https://github.com/nakao-work/portfolio/tree/main/public/works/monitor_clock" class="modal__service-github" target="_blank">
                      <img src="./assets/images/github-mark.png" class="modal__service-github-image">
                      <p class="modal__service-github-title">GitHub</p>
                    </a>
                  </div>
                </div>
              </main>
              <!-- <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Continue</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
              </footer> -->
            </div>
          </div>
        </div>

        <div class="works__container-item" data-micromodal-trigger="id-modal-2" role="button">
          <img src="./assets/images/works_questionnaire.png" class="works__container-image">
          <p class="works__container-title">アンケート</p>
          <p class="works__container-subtitle">展示会用アンケート</p>
        </div>
        <div class="modal micromodal-slide" id="id-modal-2" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1">
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-2-title">
              <header class="modal__header">
                <p class="modal__title" id="id-modal-2-title">アンケート</p>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
              </header>
              <main class="modal__content" id="id-modal-2-content">
                <div class="modal__content-left">
                  <div class="modal__description">
                    <p>展示会で自社ブースを訪れた方向けのアンケートシステムを開発しました。</p>
                    <p>名刺情報をデジタルで管理できるよう、アンケート画面上で名刺を撮影・画像として保存できる機能を実装しています。</p>
                    <p>管理画面では回答内容を一覧で確認でき、複数の展示会を一元的に管理できる仕組みになっています。</p>
                  </div>
                  <div class="modal__prog-lang">
                    <p class="modal__prog-lang-title">使用言語</p>
                    <p class="modal__prog-lang-text">HTML/CSS, SCSS, JavaScript, php, mysql</p>
                  </div>
                </div>
                <div class="modal__content-right">
                  <div class="modal__link-container">
                    <a class="modal__link c-mr-10" href="./works/questionnaire/" target="_blank">
                      <span>サイトはこちら</span>
                      <span class="material-symbols-rounded">open_in_new</span>
                    </a>
                    <a class="modal__link" href="./works/questionnaire/admin.php" target="_blank">
                      <span>管理画面はこちら</span>
                      <span class="material-symbols-rounded">open_in_new</span>
                    </a>
                  </div>
                  <!-- <div class="modal__image-container">
                    <a class="modal__image-inner" href="./works/questionnaire/" target="_blank">
                      <img class="modal__image" src="./assets/images/works_questionnaire.png">
                    </a>
                  </div> -->
                  <div class="modal__image-container">
                    <div class="swiper swiper__questionnaire">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide">
                          <a class="modal__image-inner" href="./works/questionnaire/" target="_blank">
                            <img class="modal__image" src="./assets/images/works_questionnaire.png">
                          </a>
                        </div>
                        <div class="swiper-slide">
                          <a class="modal__image-inner" href="./works/questionnaire/admin.php" target="_blank">
                            <img class="modal__image" src="./assets/images/works_questionnaire_admin.png">
                          </a>
                        </div>
                      </div>

                      <!-- ナビボタン -->
                      <div class="swiper-button-prev"></div>
                      <div class="swiper-button-next"></div>
                      <!-- ページネーションの要素 -->
                      <div class="swiper-pagination"></div>
                    </div>
                  </div>
                  <div class="modal__service">
                    <a href="https://github.com/nakao-work/portfolio/tree/main/public/works/questionnaire" class="modal__service-github" target="_blank">
                      <img src="./assets/images/github-mark.png" class="modal__service-github-image">
                      <p class="modal__service-github-title">GitHub</p>
                    </a>
                  </div>
                </div>
              </main>
              <!-- <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Continue</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
              </footer> -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="id-practice" class="section practice">
      <h2 class="section__title">Practice</h2>
      <p class="section__text">以下の作品は練習用に作成したものであり、正式なサービスではありません。</p>
      <div class="practice__container">
        <div class="practice__container-item" data-micromodal-trigger="id-modal-101" role="button">
          <img src="./assets/images/practice_molstan.png" class="practice__container-image">
          <p class="practice__container-title">molstan</p>
          <p class="practice__container-subtitle">企業風ホームページ</p>
        </div>
        <div class="modal micromodal-slide" id="id-modal-101" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1">
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-101-title">
              <header class="modal__header">
                <p class="modal__title" id="id-modal-101-title">molstan</p>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
              </header>
              <main class="modal__content" id="id-modal-101-content">
                <div class="modal__content-left">
                  <div class="modal__description">
                    <p>Bootstrapのテンプレートを使用して、企業風のHPを作成しました。細かい見た目の部分を自分で調整し、企業のイメージやサービスの内容なども自分で考えてみました。</p>
                    <p class="modal__description-note">※練習用に作成したサイトで、実在する企業ではありません。</p>
                  </div>
                  <div class="modal__prog-lang">
                    <p class="modal__prog-lang-title">使用言語</p>
                    <p class="modal__prog-lang-text">HTML/CSS, Bootstrap</p>
                  </div>
                </div>
                <div class="modal__content-right">
                  <div class="modal__link-container">
                    <a class="modal__link" href="./practice/molestam/index.html" target="_blank">
                      <span>サイトはこちら</span>
                      <span class="material-symbols-rounded">open_in_new</span>
                    </a>
                  </div>
                  <div class="modal__image-container">
                    <a class="modal__image-inner" href="./practice/molestam/index.html" target="_blank">
                      <img class="modal__image" src="./assets/images/practice_molstan.png">
                    </a>
                  </div>
                  <div class="modal__service">
                    <a href="https://github.com/nakao-work/portfolio/tree/main/public/practice/molestam" class="modal__service-github" target="_blank">
                      <img src="./assets/images/github-mark.png" class="modal__service-github-image">
                      <p class="modal__service-github-title">GitHub</p>
                    </a>
                  </div>
                </div>
              </main>
              <!-- <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Continue</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
              </footer> -->
            </div>
          </div>
        </div>
        <div class="practice__container-item" data-micromodal-trigger="id-modal-102" role="button">
          <img src="./assets/images/practice_orange.png" class="practice__container-image">
          <p class="practice__container-title">orange</p>
          <p class="practice__container-subtitle">美容室風ホームページ</p>
        </div>
        <div class="modal micromodal-slide" id="id-modal-102" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1">
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-102-title">
              <header class="modal__header">
                <p class="modal__title" id="id-modal-102-title">orange</p>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
              </header>
              <main class="modal__content" id="id-modal-102-content">
                <div class="modal__content-left">
                  <div class="modal__description">
                    <p>WordPressを使用して、美容室風のHPを作成しました。テーマを1から作成しました。納品後にお客様が編集・管理できるようなものになっていないので、今後アップデートしてく予定です。</p>
                    <p class="modal__description-note">※練習用に作成したサイトで、実在する美容室ではありません。</p>
                  </div>
                  <div class="modal__prog-lang">
                    <p class="modal__prog-lang-title">使用言語</p>
                    <p class="modal__prog-lang-text">HTML/CSS, jQuery, WordPress</p>
                  </div>
                </div>
                <div class="modal__content-right">
                  <div class="modal__link-container">
                    <a class="modal__link" href="./practice/orange/" target="_blank">
                      <span>サイトはこちら</span>
                      <span class="material-symbols-rounded">open_in_new</span>
                    </a>
                  </div>
                  <div class="modal__image-container">
                    <a class="modal__image-inner" href="./practice/orange/" target="_blank">
                      <img class="modal__image" src="./assets/images/practice_orange.png">
                    </a>
                  </div>
                  <div class="modal__service">
                    <a href="https://github.com/nakao-work/portfolio/tree/main/public/practice/orange" class="modal__service-github" target="_blank">
                      <img src="./assets/images/github-mark.png" class="modal__service-github-image">
                      <p class="modal__service-github-title">GitHub</p>
                    </a>
                  </div>
                </div>
              </main>
              <!-- <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Continue</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
              </footer> -->
            </div>
          </div>
        </div>
        <div class="practice__container-item" data-micromodal-trigger="id-modal-103" role="button">
          <img src="./assets/images/practice_uploader.png" class="practice__container-image">
          <p class="practice__container-title">File Uploader</p>
          <p class="practice__container-subtitle">ファイルアップローダー</p>
        </div>
        <div class="modal micromodal-slide" id="id-modal-103" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1">
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-103-title">
              <header class="modal__header">
                <p class="modal__title" id="id-modal-103-title">File Uploader</p>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
              </header>
              <main class="modal__content" id="id-modal-103-content">
                <div class="modal__content-left">
                  <div class="modal__description">
                    <p>ファイル共有用のファイルアップローダーを作成しました。ギガファイル便のようにファイルをアップロードするとダウンロードリンクが発行されます。</p>
                    <p>アップロード部分は勉強のためにライブラリは使わず、素のJavaScriptとphpで実装しました。</p>
                    <p>セキュリティの部分に疎かったので、ファイルの保存場所やアクセス権限の設定、ファイル拡張子の制限など良い勉強になりました。</p>
                    <p class="modal__description-note">※練習用に作成したサイトで、公開はしておりません。</p>
                  </div>
                  <div class="modal__prog-lang">
                    <p class="modal__prog-lang-title">使用言語</p>
                    <p class="modal__prog-lang-text">HTML/CSS, SCSS, JavaScript, php, mysql</p>
                  </div>
                </div>
                <div class="modal__content-right">
                  <div class="modal__link-container">
                    <a class="modal__link" href="./practice/uploader/" target="_blank">
                      <span>サイトはこちら</span>
                      <span class="material-symbols-rounded">open_in_new</span>
                    </a>
                  </div>
                  <div class="modal__image-container">
                    <a class="modal__image-inner" href="./practice/uploader/" target="_blank">
                      <img class="modal__image" src="./assets/images/practice_uploader.png">
                    </a>
                  </div>
                  <div class="modal__service">
                    <a href="https://github.com/nakao-work/portfolio/tree/main/public/practice/uploader" class="modal__service-github" target="_blank">
                      <img src="./assets/images/github-mark.png" class="modal__service-github-image">
                      <p class="modal__service-github-title">GitHub</p>
                    </a>
                  </div>
                </div>
              </main>
              <!-- <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary">Continue</button>
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
              </footer> -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="id-profile" class="section profile">
      <h2 id="id-profile-title" class="section__title">Profile</h2>
      <div class="profile__container">
        <div id="id-water-drop" class="water-drop">
          <div id="id-drop-shaped"></div>
          <div id="ripple1"></div>
          <div id="ripple2"></div>
          <div id="ripple3"></div>
        </div>
        <div id="id-profile__container-inner" class="profile__container-inner">
          <table class="company">
            <tbody>
              <tr>
                <th class="arrow_box">はじまり</th>
                <td>1992年 大分県の田舎町で生まれました。</td>
              </tr>
              <tr>
                <th class="arrow_box">学生時代</th>
                <td>
                  小学校：フットサル・野球・陸上とスポーツに夢中でした。<br>
                  中学校：ソフトテニス部でキャプテンになり、チームで県ベスト4までいったのは良い思い出です。<br>
                  高校：サッカー部で大学受験と両立しながら、高校生活を過ごしました。<br>
                  大学：大分大学に入学し、機械工学を学びました。プライベートはパチンコに明け暮れていました。
               </td>
              </tr>
              <tr>
                <th>社会人</th>
                <td>
                  造船会社に入社。仕事もそうですが、社会人としての基礎を築いていただきました。会社や先輩には今でも感謝しかありません。
                </td>
              </tr>
              <tr>
                <th>転職</th>
                <td>
                  5年半勤めた造船会社を退社。<br>
                  これまで仕事に対しては、自分のやりたいことや興味のあることというよりも、できる仕事ならなんでもいいという考え方でした。<br>
                  しかし、30歳を目前にして自分の人生を見つめ直し、造船業界の先行きに不安を感じたという点もありますが、1度自分のやりたいことにチャレンジをしてみようと決意しました。<br>                  
                  <br>
                  なぜITの仕事を選んだのかというと、大学時代に簡単なプログラミングの授業を受けたことや、社会人になってからもプライベートでゲームの攻略サイトを作ろうと思い、軽くHTMLに触れた経験がありました。<br>
                  当時は意識していませんでしたが、振り返ってみると、もともとITに対して少し興味があったのだと思います。<br>
                  最終的な決め手は、「ITってなんとなくかっこいいし、これからニーズも高まりそう」という、正直少し軽い気持ちからでしたが、それでも自分の気持ちに素直になってみようと考えました。<br>
                  <br>
                  退職後は、独学で勉強をしながら、職業訓練とオンラインスクールに通ってプログラミングの勉強をしました。<br>
                </td>
              </tr>
              <tr>
                <th>現在</th>
                <td>
                  無事転職に成功し、現在はwebエンジニアとして業務を担当しております。
                </td>
              </tr>
            </tbody>
          </table>

          <p>
            
          </p>
        </div>
      </div>
    </section>

    <div class="contact" data-micromodal-trigger="id-modal-contact" role="button">
      <p class="contact__title">お問い合わせ</p>
    </div>
    <div class="modal-contact micromodal-slide" id="id-modal-contact" aria-hidden="true">
      <div class="modal-contact__container" role="dialog" aria-modal="true" aria-labelledby="modal-contact-title">
        <header class="modal-contact__header">
          <p class="modal-contact__title" id="id-modal-contact-title">お問い合わせ</p>
          <button class="modal-contact__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal-contact__content" id="id-modal-contact-content">
          <p>このサイトや私に何かコメントがありましたら、下記フォームよりご連絡ください。</p>
          <form class="modal-contact__form">
            <input type="text" placeholder="Name" name="name" class="modal-contact__name">
            <input type="email" placeholder="Email" name="email" class="modal-contact__email">
            <textarea placeholder="Message" name="message" class="modal-contact__message"></textarea>
            <button type="submit" class="modal-contact__submit">送信</button>
            <div class="modal-contact__recaptcha">
              <p class="modal-contact__recaptcha-text">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy" class="modal-contact__recaptcha-link" target="_blank" rel="noopener noreferrer">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" class="modal-contact__recaptcha-link" target="_blank" rel="noopener noreferrer">Terms of Service</a> apply.
              </p>
            </div>
          </form>
        </main>
      </div>
    </div>

    <footer class="footer">
      <p>&copy; 2021–<span id="id-year"></span> Sho Nakao. All rights reserved.</p>
    </footer>

  </div>

  <script src="./assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

  <!-- ハンバーガーメニュー -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const btnHamburger = document.querySelector("#id-header__btn-hamburger");
      const hamburgerMenu = document.querySelector("#id-header__hamburger-nav");
      const hamburgerOverlay = document.querySelector("#id-header__hamburger-overlay");
      const hamburgerList = document.querySelector("#id-header__hamburger-list");
      const hamburgerItems = document.querySelectorAll(".header__hamburger-item");

      let isMenuOpen = false; // メニューの状態を表す変数

      const toggleMenu = () => {
        isMenuOpen = !isMenuOpen; // メニューの状態を反転

        // クラスのトグル操作
        btnHamburger.classList.toggle("is-active", isMenuOpen); // 第二引数がtrueの時クラスを追加。falseの時クラスを削除。
        hamburgerMenu.classList.toggle("is-active", isMenuOpen);
        hamburgerOverlay.classList.toggle("is-active", isMenuOpen);
        hamburgerList.classList.toggle("is-active", isMenuOpen);

        // 属性操作
        btnHamburger.setAttribute("aria-expanded", isMenuOpen.toString());  // 第一引数の属性名の値を第二引数でセットする。
        btnHamburger.setAttribute("aria-label", isMenuOpen ? "メニューを閉じる" : "メニューを開く");
        hamburgerList.setAttribute("aria-hidden", (!isMenuOpen).toString());
        document.body.style.overflow = isMenuOpen ? "hidden" : "";
      };

      const handleKeydown = (e) => {
        if (e.key === "Escape" && isMenuOpen) {
          toggleMenu();
        }
      };

      if(btnHamburger) {
        btnHamburger.addEventListener("click", toggleMenu);
      }
      if(hamburgerItems) {
        hamburgerItems.forEach((item) => {
          item.addEventListener("click", toggleMenu);
        });
      }
      document.addEventListener("keydown", handleKeydown);
    });
  </script>

  <!-- skill chart -->
  <script>
    const chartF = document.querySelector('#js-chart-frontend');
    const chartB = document.querySelector('#js-chart-backend');
    const chartO = document.querySelector('#js-chart-other');
  
    //　フロントエンド
    const dataF = {
      labels: [
        'HTML/CSS',
        'Javascript',
        'JQuery',
        'Vue.js',
        'Bootstrap',
        'Wordpress'
      ],
      datasets: [{
        label: 'フロントエンド',
        data: [4, 4, 3, 0, 1, 2],
        fill: true,
        backgroundColor: 'rgba(237, 116, 159, 0.2)',
        borderColor: 'rgb(237, 116, 159)',
        pointBackgroundColor: 'rgb(237, 116, 159)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(237, 116, 159)'
      }]
    };
    new Chart(chartF, {
      type: 'radar',
      data: dataF,
      options: {
        elements: {
          line: {
            borderWidth: 1
          }
        },
        scales: {
          r: {
              max: 5,
              min: 0,
              ticks: {
                  stepSize: 1
              }
          }
        },
        maintainAspectRatio: false
      },
    });


    //　バックエンド
    const dataB = {
      labels: [
        'PHP',
        'Laravel',
        'MySQL',
        'Node.js',
        'Apache'
      ],
      datasets: [{
        label: 'バックエンド',
        data: [4, 1, 3, 0, 3],
        fill: true,
        backgroundColor: 'rgba(79, 207, 160, 0.2)',
        borderColor: 'rgb(79, 207, 160)',
        pointBackgroundColor: 'rgb(79, 207, 160)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(79, 207, 160)'
      }]
    };
    new Chart(chartB, {
      type: 'radar',
      data: dataB,
      options: {
        elements: {
          line: {
            borderWidth: 1
          }
        },
        scales: {
          r: {
              max: 5,
              min: 0,
              ticks: {
                  stepSize: 1
              }
          }
        },
        maintainAspectRatio: false
      },
    });


    //　その他
    const dataO = {
      labels: [
        'Linux',
        'Git/GitHub',
        'Docker',
        'AWS'
      ],
      datasets: [{
        label: 'その他',
        data: [2, 2, 2, 1],
        fill: true,
        backgroundColor: 'rgba(231, 231, 61, 0.2)',
        borderColor: 'rgb(231, 231, 61)',
        pointBackgroundColor: 'rgb(231, 231, 61)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(231, 231, 61)'
      }]
    };
    new Chart(chartO, {
      type: 'radar',
      data: dataO,
      options: {
        elements: {
          line: {
            borderWidth: 1
          }
        },
        scales: {
          r: {
              max: 5,
              min: 0,
              ticks: {
                  stepSize: 1
              }
          }
        },
        maintainAspectRatio: false
      },
    });
  </script>  
  
  <!-- profileアニメーション -->
  <script>
    const scrollTarget = document.querySelector('#id-profile');  //ターゲット要素を取得
    const waterDrop = document.querySelector('#id-water-drop');
    const dropShaped = document.querySelector('#id-drop-shaped');
    const ripple1 = document.querySelector('#ripple1');
    const ripple2 = document.querySelector('#ripple2');
    const ripple3 = document.querySelector('#ripple3');
    const profileContainerInner = document.querySelector('#id-profile__container-inner');
    let scrollOverFlag = false;

    // スクロール
    window.addEventListener('scroll', function() {
      var scroll = window.scrollY; //スクロール量を取得
      var windowHeight = window.innerHeight; //画面の高さを取得
      var targetPos = scrollTarget.getBoundingClientRect().bottom + scroll; //ターゲット要素の位置を取得
      if (!scrollOverFlag && scroll > targetPos - windowHeight) { //スクロール量 > ターゲット要素の位置
        dropShaped.classList.add("drop-shaped");
        ripple1.classList.add("ripple");
        ripple2.classList.add("ripple", "delay1");
        ripple3.classList.add("ripple", "delay2");

        scrollOverFlag = true;
      }
    });

    // 水アニメーション
    dropShaped.addEventListener('animationend', () => {
      dropShaped.style.display = 'none'; // アニメーション終了後に非表示にする
    });

    ripple3.addEventListener('animationend', () => {
      waterDrop.style.display = 'none'; // アニメーション終了後に非表示にする
      profileContainerInner.style.display = 'block'; // アニメーション終了後に表示する
    });
  </script>

  <!-- Swiper -->
  <script>
    const swiper = new Swiper('.swiper', {
      loop: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination', // ページネーションの要素
        clickable: true,          // ドットをクリック可能にする
      },
    });
  </script>

  <!-- Micromodal -->
  <script>
    MicroModal.init({
      disableScroll: true, // モーダルが開いている間に、背景スクロールを無効にする。 
      disableFocus: true,

      // 問い合わせのモーダル展開時は背景スクロール許可
      onShow: modal => {
        if (modal.id === "id-modal-contact") {
          document.body.style.overflow = "auto";   // 背景スクロール許可
        } else {
          document.body.style.overflow = "hidden"; // 背景スクロール禁止
        }
      },
      onClose: modal => {
        document.body.style.overflow = ""; // 元に戻す
      }
    });
    

    // オーバーレイの要素に"data-micromodal-close"属性を付与してしまうと、
    // 子要素のcontainerの余白をクリックしたときもモーダルが閉じてしまうのでその代替策
    document.querySelectorAll(".modal__overlay").forEach(overlay => {
      overlay.addEventListener("click", function(event) {
        if (event.target === this) {
          const closeButton = this.querySelector(".modal__close");  // ×ボタンの要素を取得
          closeButton.click();  // ×ボタンをjsからクリック
        }
      });
    });
  </script>

  <!-- お問い合わせ送信・reCAPTCHA -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.querySelector('.modal-contact__form');

      form.addEventListener('submit', async (e) => {
        e.preventDefault(); // ページリロードを防ぐ

        // recaptchaのトークンを取得
        const recaptchaToken = await grecaptcha.execute("<?php echo RECAPTCHA_SITE_KEY ?>", { action: "submit" });

        const formData = new FormData(form);
        formData.append("recaptcha-response", recaptchaToken);

        try {
          const response = await fetch("<?php echo SEND_MAIL_ENDPOINT ?>", {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.status == "success") {
            contactComplete("success", "送信が完了しました！");
            form.reset(); // フォームをリセット
          } else {
            contactComplete('error', "送信に失敗しました。");
            console.log(data.error);
          }

        } catch (error) {
            contactComplete('error', "送信中にエラーが発生しました。");
            console.log(error);
        }
      });
    });
  </script>

  <!-- SweetAlert2 -->
  <script>
    function contactComplete(status, message) {
      Swal.fire({
        title: `${status}`,
        text: message,
        icon: `${status}`,
        customClass: {
          container: 'success-alert',   // アラート全体のコンテナ
          popup: 'success-alert__popup',           // ポップアップの部分
          header: 'success-alert__header',         // ヘッダー部分
          title: 'success-alert__title',           // タイトル
          closeButton: 'success-alert__close',     // 閉じるボタン
          icon: 'success-alert__icon',             // アイコン
          image: 'success-alert__image',           // 画像
          htmlContainer: 'success-alert__html-container', // HTMLコンテンツ
          input: 'success-alert__input',           // 入力フォーム
          actions: 'success-alert__actions',       // ボタン部分
          confirmButton: 'success-alert__confirm', // 確定ボタン
          cancelButton: 'success-alert__cancel',   // キャンセルボタン
          footer: 'success-alert__footer',         // フッター
        }
        // customClass: 'success-alert',
      });
    }
  </script>
</body>
</html>