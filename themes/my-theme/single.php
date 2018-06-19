<?php
  if(get_post_type() !== 'post'){
    $slug = get_post_type_object(get_post_type())->name;
    $name = get_post_type_object(get_post_type())->label;
  }else {
    $cat  = get_the_category();
    $cat  = $cat[0];
    $id   = $cat->term_id;
    $slug = $cat->slug;
    $name = $cat->name;
  }
get_header(); ?>
  <div class="theme-pagetitle">
    <h2><img src="<?php echo get_template_directory_uri().'/img/page/bnr_'.$slug.'.png';?>" width="1280" height="160" alt="<?php echo $name;?>"></h2>
  </div>
  <nav class="breadcrumb">
    <ul class="breadcrumb-list">
      <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>/">ホーム</a></li>
      <li class="breadcrumb-item"><a href="<?php echo home_url().'/'.$slug.'/'; ?>"><?php echo $name;?></a></li>
      <li class="breadcrumb-item"><?php the_title(); ?></li>
    </ul>
  </nav>
  <div class="l-contents">
    <main class="l-main single">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <p class="date"><?php the_time('Y年n月j日') ?></p>
            <h3><?php the_title(); ?></h3>
            <div class="article">
                <p><?php echo nl2br(get_the_content()); ?></p>
            </div><!-- /.article -->
            <ul id="page_navi">
<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
if ( !empty( $prev_post ) ): ?>
                <li><?php previous_post_link('%link', '前へ', TRUE); ?></li>
<?php endif; ?>
<?php
if ( !empty( $next_post ) ): ?>
                <li><?php next_post_link('%link', '次へ', TRUE); ?></li>
<?php endif; ?>
                <li><a href="<?php echo home_url().'/'.$slug.'/'; ?>">一覧に戻る</a></li>
            </ul><!-- /#page_nav -->
<?php endwhile; ?>
<?php else : ?>
            <h3>記事はまだありません。</h3>
<?php
    endif;
    wp_reset_postdata();
?>
    </main><!-- /l-main  -->
<?php get_sidebar(); ?>
  </div><!-- /.l-contents -->
<?php get_footer(); ?>
