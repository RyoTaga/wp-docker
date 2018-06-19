<?php
  $pageobj   = $wp_query->get_queried_object();
  $post_type = $pageobj->name;
  $name      = $pageobj->labels->name;
  if(isset($_GET['page'])){
    $paged = $_GET['page'];
  }
get_header(); ?>
  <div class="theme-pagetitle">
    <h2><img src="<?php echo get_template_directory_uri().'/img/page/bnr_'.$post_type.'.png';?>" width="1280" height="160" alt="<?php echo $name; ?>"></h2>
  </div>
  <nav class="breadcrumb">
    <ul class="breadcrumb-list">
      <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>/">ホーム</a></li>
      <li class="breadcrumb-item"><?php echo $name; ?></li>
    </ul>
  </nav>
  <div class="l-contents">
    <main class="l-main custompost">
      <?php $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 2,
        'paged'          => $paged
      ); ?>
    <?php $my_query = new WP_Query($args); ?>
    <?php if ($my_query->have_posts()): while ($my_query->have_posts()) : $my_query->the_post(); ?>
      <div class="post">
        <p class="date"><?php the_time('Y年n月j日') ?></p>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="excerpt">
          <p><?php the_excerpt();?></p>
        </div>
      </div><!-- /.post -->
    <?php endwhile; ?>
      <div id="pager">
        <?php
          global $wp_rewrite;
          $paginate_base = get_pagenum_link(1);
          if(strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()){
            $paginate_format = '';
            $paginate_base = add_query_arg('page','%#%');
          } else {
            $paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') . '?page=%#%';
            $paginate_base .= '%_%';
          }
          echo paginate_links(array(
            'base' => $paginate_base,
            'format' => $paginate_format,
            'total' => $my_query->max_num_pages,
            'mid_size' => 5,
            'current' => ($paged ? $paged : 1),
            'prev_text' => '＜',
            'next_text' => '＞',
            'add_args' => false
          ));
        ?>
      </div><!-- /#pager -->
    <?php else : ?>
      <h3>記事はまだありません。</h3>
    <?php
      endif;
      wp_reset_query();
    ?>
    </main><!-- /.l-main  -->
    <?php get_sidebar(); ?>
  </div><!-- /.l-contents -->
<?php get_footer(); ?>
