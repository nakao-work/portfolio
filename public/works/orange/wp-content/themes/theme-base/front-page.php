<?php get_header(); //ヘッダー：header.phpを取得、表示 ?>


<div class="home--wrapper">
    <?php /* the_content(); // 本文を出力 */ ?>

    <div class="home--top-bg-container">
        <img src="<?php echo get_template_directory_uri() ?>/images/home_top_bg.jpg" class="home--top-bg-image">
        <h1 class="home--top-bg-text">orange</h1>
    </div>

    <div id="home--concept" class="home--concept-container">
        <div class="home--concept-image">
            <img src="<?php echo get_template_directory_uri() ?>/images/home_concept.jpg">
        </div>

        <div class="home--concept-column">
            <h2>Concept</h2>
            <p>当店は自然な素材や植物を活かした居心地の良い空間で、お客様に癒しと美を提供する美容室です。</p><br>
            <p>店内のインテリアにもこだわり、自然な木材を使った家具や植物を飾り、居心地の良い空間を演出しています。</p><br>
            <p>お客様がゆっくりとくつろげるように、ソファやマッサージチェアもご用意しております。</p>
        </div>
    </div>

    <div id="home--menu" class="home--menu-container fadein fadein-bottom">
        <h2>Menu</h2>
        <div class="home--menu-list">
            <div class="home--menu-cut home--menu-category-container">
                <div class="home--menu-category-title">カット</div>
                <dl class="home--menu-category-price">
                    <dt>カット</dt>
                    <dd>￥4,950</dd>
                    <dt>メンズカット+マユカット</dt>
                    <dd>￥5,500</dd>
                    <dt>中・高校生カット</dt>
                    <dd>￥3,850</dd>
                    <dt>小学生以下カット</dt>
                    <dd>￥3,300</dd>
                    <dt>前髪カット</dt>
                    <dd>￥1,100</dd>
                </dl>
            </div>
            <div class="home--menu-color home--menu-category-container">
                <div class="home--menu-category-title">カラー</div>
                <dl class="home--menu-category-price">
                    <dt>オーガニックカラー</dt>
                    <dd>￥8,250</dd>
                    <dt>ヘナカラー</dt>
                    <dd>￥9,350</dd>
                    <dt>イルミナカラー</dt>
                    <dd>￥9,900</dd>
                    <dt>ザクロペインター</dt>
                    <dd>￥9,900</dd>
                    <dt>ダブルカラー（デザインカラー）</dt>
                    <dd>￥14,300</dd>
                </dl>
            </div>
            <div class="home--menu-straightening home--menu-category-container">
                <div class="home--menu-category-title">縮毛矯正</div>
                <dl class="home--menu-category-price">
                    <dt>ストレート</dt>
                    <dd>￥15,950</dd>
                    <dt>フロントストレート</dt>
                    <dd>￥7,150</dd>
                    <dt>ケアストレート</dt>
                    <dd>￥18,150</dd>
                </dl>
            </div>
            <div class="home--menu-treatment home--menu-category-container">
                <div class="home--menu-category-title">トリートメント</div>
                <dl class="home--menu-category-price">
                    <dt>クイックトリートメント</dt>
                    <dd>￥4,400</dd>
                    <dt>アマトラ・アフィア・トリートメント</dt>
                    <dd>￥7,700</dd>
                </dl>
            </div>
            <div class="home--menu-hair-set home--menu-category-container">
                <div class="home--menu-category-title">ヘアセット</div>
                <dl class="home--menu-category-price">
                    <dt>セット</dt>
                    <dd>￥4,400</dd>
                </dl>
            </div>
            <div class="home--menu-scalp-care home--menu-category-container">
                <div class="home--menu-category-title">ヘッドスパ</div>
                <dl class="home--menu-category-price">
                    <dt>ヘッドスパ</dt>
                    <dd>￥4,400</dd>
                    <dt>強髪プログラム【ヒト幹細胞培養液】</dt>
                    <dd>￥3,850</dd>
                </dl>
            </div>
        </div>
    </div>

    <div id="home--stylist" class="home--stylist-container fadein fadein-bottom">
        <h2>Stylist</h2>
        <div class="home--stylist-list">
            <div class="home--stylist-item">
                <img src="<?php echo get_template_directory_uri() ?>/images/home_stylist_sample1.png">
                <div class="home--stylist-item-content">
                    <p class="home--stylist-name-ja">伊藤 健太</p>
                    <p class="home--stylist-name-en">Ito Kenta</p>
                    <p class="home--stylist-text">お客様の魅力を最大限に引き出すために日々努力しています。トレンドを押さえつつ、個々のライフスタイルに合ったスタイルを提供し、笑顔と満足をお届けします。一緒に素敵な変化を楽しみましょう！</p>
                </div>
            </div>
            <div class="home--stylist-item">
                <img src="<?php echo get_template_directory_uri() ?>/images/home_stylist_sample2.png">
                <div class="home--stylist-item-content">
                    <p class="home--stylist-name-ja">高橋 大輔</p>
                    <p class="home--stylist-name-en">Takahashi Daisuke</p>
                    <p class="home--stylist-text">お客様の髪を美しく、健康に保つことが私の喜びです。お客様の髪質や顔型に合わせて、似合うヘアスタイルをご提案いたします。また、髪のダメージを最小限に抑える施術を心がけております。お気軽にご相談ください。</p>
                </div>
            </div>
            <div class="home--stylist-item">
                <img src="<?php echo get_template_directory_uri() ?>/images/home_stylist_sample3.jpg">
                <div class="home--stylist-item-content">
                    <p class="home--stylist-name-ja">佐々木 健一</p>
                    <p class="home--stylist-name-en">Sasaki Kenichi</p>
                    <p class="home--stylist-text">ヘアスタイルは、その人の印象を大きく左右します。お客様の個性を引き出すヘアスタイルをご提案いたします。また、トレンドを取り入れたヘアスタイルもご提案いたします。お気軽にご相談ください。</p>
                </div>
            </div>
        </div>
    </div>

    <div id="home--access" class="home--access-container">
        <div class="home--access-map fadein fadein-left">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12740.755284939169!2d131.59475992426556!3d33.229531938430696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f10.0!3m3!1m2!1s0x35469f7b237151d7%3A0x48203d64a0f6e49e!2z44OI44Kt44OPIOacrOW6lw!5e0!3m2!1sja!2sjp!4v1690383215554!5m2!1sja!2sjp" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="home--access-column fadein fadein-right">
            <h2>Access</h2>
            <p>〒870-8688<br>大分県大分市府内町２丁目１−４</p>
            <p>営業時間　9:30~18:30<br>定休日　月曜日</p>
            <p>電話番号　000-000-0000<br>電話受付は18:00迄　(完全予約制)</p>
        </div>
    </div>
</div>

<?php get_footer(); //フッター：footer.phpを取得、表示 ?>