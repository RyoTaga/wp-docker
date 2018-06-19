<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css">
<?php
    if(is_page()&&!is_front_page()) echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/page.css">'."\n";
    wp_head();
?>
</head>
<body <?php body_class(); ?>>
  <header id="header" class="header l-inner">
    <h1 class="header-catch">h1テキストh1テキストh1テキストh1テキストh1テキスト</h1>
    <p class="header-logo"><a href="<?php echo home_url(); ?>/">ロゴ</a></p>
    <nav id="gnavi" class="gnavi">
      <ul class="gnavi-list">
        <li class="gnavi-item"><a href="<?php echo home_url(); ?>/">ホーム</a></li>
        <li class="gnavi-item"><a href="<?php echo home_url(); ?>/">メニュー1</a></li>
        <li class="gnavi-item"><a href="<?php echo home_url(); ?>/">メニュー2</a></li>
        <li class="gnavi-item"><a href="<?php echo home_url(); ?>/news/">NEWS</a></li>
        <li class="gnavi-item"><a href="<?php echo home_url(); ?>/custompost/">カスタム投稿</a></li>
        <li class="gnavi-item"><a href="<?php echo home_url(); ?>/contact/">お問い合わせ</a></li>
      </ul>
    </nav>
  </header>
