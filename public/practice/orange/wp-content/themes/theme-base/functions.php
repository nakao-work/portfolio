<?php

//define('WP_DEBUG',true);
//define('WP_THEMES_ROOT',get_template_directory_uri());

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!empty($_SERVER['DOCUMENT_ROOT']) && !defined('WWW_ROOT')) {
    define('WWW_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS);
}
function wpinc($file) {
    include get_template_directory() . DS . $file;
}



/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/
/* カスタム投稿タイプ
============================================== */
function custom_entry_post_type() {
        $labels = array(
                'name' => 'カスタム投稿',
                'singular_name' => 'カスタム投稿',
                'add_new_item' => 'カスタム投稿を追加',
                'add_new' => '新規追加',
                'new_item' => '新しい記事',
                'view_item' => 'このカスタム投稿を表示',
                'not_found' => '記事がありません',
                'not_found_in_trash' => 'ゴミ箱にカスタム投稿の記事はありません。',
                'search_items' => '記事を検索',
        );
        $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'query_var' => true,
                'hierarchical' => false,
                'menu_position' => 5,
                'supports' => array('title','editor','thumbnail',
      'custom-fields','excerpt','author','trackbacks',
      'comments','revisions','page-attributes'),
                'has_archive' => true
        );
        register_post_type('custom_entry', $args);
        register_taxonomy('custom_categories','custom_entry', array(
                'hierarchical' => true,
                'update_count_callback' => '_update_post_term_count',
                'label' => 'カテゴリー',
                'singular_label' => 'カテゴリー',
                'public'=> true,
                'show_ui' => true )
        );
}
add_action('init', 'custom_entry_post_type');

/* cssとjs読み込み
============================================== */
function my_enqueue_scripts() {
  wp_enqueue_style( 'sanitize-style', get_template_directory_uri() . '/css/sanitize.css', array(), date("YmdHis", filemtime(get_theme_file_path() . '/css/sanitize.css')));
  wp_enqueue_style( 'base-style', get_template_directory_uri() . '/style.css', array(), date("YmdHis", filemtime(get_theme_file_path() . '/style.css')));

  wp_enqueue_script( 'base-script', get_template_directory_uri() . '/js/script.js', array('jquery'), date('YmdHis', filemtime(get_theme_file_path() . '/js/script.js')));
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );


/* pタグの自動挿入機能
============================================== */
add_filter('the_content', 'wpautop_filter', 9);
function wpautop_filter($content) {
  global $post;
  $remove_filter = false;
 
  //自動整形を無効にする投稿タイプを記述 ＝固定ページ
  $arr_types = array('page');
  $post_type = get_post_type( $post->ID );
  if (in_array($post_type, $arr_types)){
    $remove_filter = true;
  }
 
  //投稿ページ以外の自動整形を無効にしたければ
  /* if (!is_single()){
    $remove_filter = true;
  } */
 
  // 特定のページの自動整形を無効にしたければ*****にページIDを入れる
  /* if (get_the_ID() == *****){
    $remove_filter = true;
  }
 
  if ( $remove_filter ) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
  } */
 
  return $content;
}


/* メニュー
============================================== */
function theme_custom_setup()
{
  register_nav_menu('header', 'ヘッダーメニュー');
  register_nav_menu('footer', 'フッターメニュー');
}
 
add_action('after_setup_theme', 'theme_custom_setup');


/* コンタクトフォーム7
============================================== */
//　確認用メールアドレスのバリデーション
add_filter( 'wpcf7_validate_email', 'wpcf7_validate_email_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_validate_email_filter_extend', 11, 2 );
function wpcf7_validate_email_filter_extend( $result, $tag ) {
    $type = $tag['type'];
    $name = $tag['name'];
    $_POST[$name] = trim( strtr( (string) $_POST[$name], "n", " " ) );
    if ( 'email' == $type || 'email*' == $type ) {
        if (preg_match('/(.*)_confirm$/', $name, $matches)){ //確認用メルアド入力フォーム名を ○○○_confirm としています。
            $target_name = $matches[1];
            if ($_POST[$name] != $_POST[$target_name]) {
                if (method_exists($result, 'invalidate')) {
                    $result->invalidate( $tag,"確認用のメールアドレスが一致していません");
                } else {
                    $result['valid'] = false;
                    $result['reason'][$name] = '確認用のメールアドレスが一致していません';
                }
            }
        }
    }
    return $result;
}


//　問い合わせ完了後　thanks ページにリダイレクト
add_action( 'wp_footer', 'kaiza_wp_footer' );
function kaiza_wp_footer() {
  global $post;
 
  if( is_page('contact') || is_page('entry') ){ //他のページで出したくないので、ページ特定
    $url = get_permalink($post->ID);
    ?>
    <script type="text/javascript">
      document.addEventListener( 'wpcf7mailsent', function( event ) {
        location.replace("<?php echo $url; ?>thanks/");
      }, false );
    </script>
  <?php
  }
}


