<?php

/* 管理画面関連 -------------------------------*/

//ログイン画面のロゴを変更
// function login_logo(){
//     echo '<style type="text/css">
// .login h1 a {
// background-image:url('.get_template_directory_uri().'/admin-logo.png);
// background-size:274px,63px;
// width:274px;
// height:63px;
// }
// </style>';
// }
// add_action('login_head', 'login_logo');

// 使用しないメニューを非表示にする
// function remove_admin_menus() {
//     global $menu;
//     // unsetで非表示にするメニューを指定
//     unset($menu[2]);      // ダッシュボード
//     unset($menu[5]);      // 投稿
//     unset($menu[10]);     // メディア
//     unset($menu[20]);     // 固定ページ
//     unset($menu[25]);     // コメント
//     unset($menu[60]);     // 外観
//     unset($menu[65]);     // プラグイン
//     unset($menu[70]);     // ユーザー
//     unset($menu[75]);     // ツール
//     unset($menu[80]);     // 設定
// }
// add_action('admin_menu', 'remove_admin_menus');

// エディタで自動整形制御 （htmlテキストエディタでpタグを自動生成させない）
add_action('init', function() {
    remove_filter('the_title', 'wptexturize');
    remove_filter('the_content', 'wptexturize');
    remove_filter('the_excerpt', 'wptexturize');
    remove_filter('the_title', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('the_editor_content', 'wp_richedit_pre');
});

add_filter('tiny_mce_before_init', function($init) {
    $init['wpautop'] = false;
    $init['apply_source_formatting'] = true;
    return $init;
});

// 固定ページのビジュアルエディタ無効化
function disable_visual_editor_in_page(){
    global $typenow;
    if( $typenow == 'page' ){
        add_filter('user_can_richedit', 'disable_visual_editor_filter');
    }
}
function disable_visual_editor_filter(){
    return false;
}
add_action( 'load-post.php', 'disable_visual_editor_in_page' );
add_action( 'load-post-new.php', 'disable_visual_editor_in_page' );



/* 投稿名変更・カスタム投稿・カスタム分類（タクソノミー）関連 ------------*/

//投稿名変更
// function change_post_menu_label() {
//     global $menu;
//     global $submenu;
//     $menu[5][0]                 = 'お知らせ';
//     $submenu['edit.php'][5][0]  = 'お知らせ一覧';
//     $submenu['edit.php'][10][0] = '新しいお知らせ';
//     $submenu['edit.php'][16][0] = 'タグ';
//     //echo ”;
// }
// function change_post_object_label() {
//     global $wp_post_types;
//     $labels                     = &$wp_post_types['post']->labels;
//     $labels->name               = 'お知らせ';
//     $labels->singular_name      = 'お知らせ';
//     $labels->add_new            = _x('新規追加', 'お知らせ');
//     $labels->add_new_item       = '新しいお知らせ';
//     $labels->edit_item          = 'お知らせの編集';
//     $labels->new_item           = '新しいお知らせ';
//     $labels->view_item          = 'お知らせを表示';
//     $labels->search_items       = 'お知らせ検索';
//     $labels->not_found          = 'お知らせが見つかりませんでした';
//     $labels->not_found_in_trash = 'ゴミ箱のお知らせにも見つかりませんでした';
// }
// add_action( 'init', 'change_post_object_label' );
// add_action( 'admin_menu', 'change_post_menu_label' );

// カスタム投稿登録
function register_cpt_custompost() {
//カスタム投稿の部分を任意の文字列へ変更
    $labels = array(
        'name'               => _x( 'カスタム投稿', 'custompost' ),
        'singular_name'      => _x( 'カスタム投稿', 'custompost' ),
        'add_new'            => _x( '新規追加', 'custompost' ),
        'add_new_item'       => _x( '新しいカスタム投稿を追加', 'custompost' ),
        'edit_item'          => _x( 'カスタム投稿を編集', 'custompost' ),
        'new_item'           => _x( 'カスタム投稿を追加', 'custompost' ),
        'view_item'          => _x( 'カスタム投稿を見る', 'custompost' ),
        'search_items'       => _x( 'カスタム投稿検索', 'custompost' ),
        'not_found'          => _x( 'カスタム投稿はありません', 'custompost' ),
        'not_found_in_trash' => _x( 'ゴミ箱にカスタム投稿はありません', 'custompost' ),
        'parent_item_colon'  => _x( '親 カスタム投稿:', 'custompost' ),
        'menu_name'          => _x( 'カスタム投稿', 'custompost' ),
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_position' => 5,                          // この投稿タイプが表示されるメニューの位置。5で投稿の下
        'menu_icon'     => 'dashicons-format-aside',  // 管理画面のメニューアイコン名 https://developer.wordpress.org/resource/dashicons/
        'supports'      => array(                      // このカスタム投稿内で使用する機能
            'title',                                     // （タイトル）
            'editor',                                    // （内容の編集）
            'author',                                    // （作成者）
            'thumbnail',                                 // （アイキャッチ画像）
            'excerpt',                                   // （抜粋）
            'trackbacks',                                // （トラックバック送信）
            'custom-fields',                             // （カスタムフィールド）
            'comments',                                  // （コメントの他、編集画面にコメント数のバルーンを表示する）
            'revisions',                                 // （リビジョンを保存する）
            'page-attributes',                           // （メニューの順序。「親〜」オプションを表示するために hierarchical が true であること）
            'post-formats'                               // （投稿のフォーマットを追加。投稿フォーマットを参照）
        ),
        // 'taxonomies'    => array( 'customcat' ),       // このカスタム投稿で使用するカスタム分類
        'has_archive'   => true                        // この投稿タイプのアーカイブを有効にする
    );

    register_post_type( 'custompost', $args );

    //カスタム分類（タクソノミー）登録
    // register_taxonomy(
    //     'customcat',                 // カスタム分類の名前
    //     'custompost',                // このカスタム分類を使う投稿タイプ、もしくはカスタム投稿タイプ
    //     array(
    //         'label' => 'カスタム分類',   // カスタム分類表示名
    //         'hierarchical' => true   // trueでカテゴリーのように階層あり、falseでタグのように階層化なし
    //     )
    // );
}
add_action( 'init', 'register_cpt_custompost' );



/* ヘッダ関連 ----------------------------------*/
// titleタグを有効化
add_theme_support( 'title-tag' );

function load_script(){
    wp_enqueue_script('jquery');
}
add_action('init', 'load_script');

// 不要ヘッダlink削除
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

//version情報削除
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles', 10 );

// デフォルトのcanonicalの設定無効化
// remove_action('wp_head', 'rel_canonical');


/* WordPressタグのカスタマイズ ---------------------*/

// 「続きを読む」をカスタマイズ
function my_excerpt_more($post) {
    return  '…<br><span><a href="'. get_permalink($post->ID) . '">' . '続きを見る' . '</a></span>';
}
function my_trim_all_excerpt( // 抜粋（the_excerpt()）を適当な文字数でカット
    $text = '' ,
    $cut  = 100 //表示する文字数
     ) {
    global $post;
    $raw_excerpt = $text;
    if ( '' == $text ) {
        $text = get_the_content('');
        $text = strip_shortcodes( $text );
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
        $text = strip_tags($text);
    }
    $excerpt_mblength = apply_filters('excerpt_mblength', $cut );
    $excerpt_more     = my_excerpt_more( $post );
    $text             = wp_trim_words( $text, $excerpt_mblength, $excerpt_more );
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'my_trim_all_excerpt' );



/* 投稿関連 -----------------------------------*/

// アイキャッチ画像を有効化
add_theme_support('post-thumbnails');

// 記事の一番最初の画像を取得
function catch_that_image() {
    global $post, $posts;
    if ( preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)){
        $first_img = $matches [1] [0];
    } else {
        $first_img = false;
    }
    return $first_img;
}

// メディア画像サイズ追加
// add_image_size( 'category', 148, 98, true );
// add_image_size( 'post', 300, 300, false );

// 特定のカテゴリーの投稿をショートコード[list num="表示数" cat="カテゴリーID"]で表示
function get_cat_items($atts, $content = null){
    extract(shortcode_atts(array(
        'num' => '5',  // デフォルトの表示数
        'cat' => '1'   // デフォルトのカテゴリーID
    ), $atts));
    global $post;
    $oldpost = $post;
    $myposts = get_posts('numberposts='.$num.'&category='.$cat);
    $retHtml = '';
    foreach($myposts as $post){
        setup_postdata($post);
        $retHtml.='<li><span>'.get_post_time('Y年m月d日').'</span><a href="'.get_the_permalink().'">'.mb_substr(get_the_title('','',false), 0, 40).'</a></li>'."\n";
    }
    $post = $oldpost;
    return $retHtml;
}
add_shortcode('list', 'get_cat_items');

// カスタム投稿情報取得
function get_custom_items($atts, $content = null){
    extract(shortcode_atts(array(
        "num" => '3'  // デフォルトの表示数
    ), $atts));
    global $post;
    $oldpost = $post;
    $myposts = get_posts('post_type=items&numberposts='.$num.'&orderby=id');
    $retHtml = '';
    foreach($myposts as $post) {
        setup_postdata($post);
        $image_id = get_field('custom_image');
        $size = "thumbnail";
        $image = wp_get_attachment_image_src( $image_id, $size );
        $retHtml.='
            <p class="thumb"><a href="'.get_the_permalink().'"><img src="'.$image[0].'" width="150" height="150" alt="'.get_the_title().'"></a></p>'."\n".'
            <p><span>'.get_post_time('Y年m月d日').'</span><a href="'.get_the_permalink().'">'.mb_substr(get_the_title('','',false), 0, 40).'</a></p>
        ';
    }
    $post = $oldpost;
    return $retHtml;
}
add_shortcode("customposts", "get_custom_items");

// ショートコード[shortcode]で表示
function get_code(){
    return '<p>ショートコード[shortcode]で表示 <span>URL = '.home_url().'</span></p>';
}
add_shortcode('shortcode', 'get_code');

?>
