<?php get_header(); //ヘッダー：header.phpを取得、表示 ?>
 
<div class="container">
    <div class="row">
        <div class="col-sm-9">
 
            <?php get_template_part( 'inc/breadcrumb' ); //パンくずを表示 ?>
            <?php while ( have_posts() ) : the_post(); //WordPressお約束のメインループ ?>
                <?php the_content(); //エディタで登録したコンテンツを表示 ?>
            <?php endwhile; ?>

            <?php
            $fields = $cfs->get('introduction'); 
            foreach ($fields as $field) :
            ?>
            <img class="top-style" src="<?php echo $field['slide_image']; ?>" alt="<?php the_title(); ?>" width="auto" height="auto">
            <div><?php echo $field['text']; ?></div>
            <?php endforeach; ?>
 
        </div>
        
    </div>
</div>
 
<?php get_footer(); //フッター：footer.phpを取得、表示 ?>