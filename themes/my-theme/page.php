<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $page = get_page(get_the_ID()); ?>
  <div class="theme-pagetitle">
    <h2><img src="<?php echo get_template_directory_uri().'/img/page/bnr_'.$page->post_name.'.png';?>" width="1280" height="160" alt="<?php the_title();?>"></h2>
  </div>
  <nav class="breadcrumb">
    <ul class="breadcrumb-list">
      <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>/">ホーム</a></li>
      <li class="breadcrumb-item"><?php the_title(); ?></li>
    </ul>
  </nav>
  <div class="l-contents">
    <main class="l-main page">
<?php the_content(); ?>
<?php
    endwhile;
    endif;
    wp_reset_postdata();
?>
    </main><!-- /l-main -->
<?php get_sidebar(); ?>
  </div><!-- /.l-contents -->
<?php get_footer(); ?>
