<?php get_header(); ?>
  <div id="visual" class="visual">
    <div class="visual-inner">
      <!-- <p><img src="<?php echo get_template_directory_uri(); ?>/img/visual.png" width="1200" height="300" alt="ビジュアル"></a></p> -->
    </div>
  </div><!-- /.visual -->
  <div class="l-contents">
    <main class="l-main top">
<?php while (have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>

    </main><!-- /.l-main -->
<?php get_sidebar(); ?>
  </div><!-- /.l-contents -->
<?php get_footer(); ?>
