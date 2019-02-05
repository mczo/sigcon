<?php
//站点标题
add_theme_support('title-tag');

//feed
add_theme_support( 'automatic-feed-links' );

//文章格式
add_theme_support( 'post-formats', array( 'gallery', 'video' ) );

//自定义顶部图像
add_theme_support('custom-header', array(
    'uploads' => true,
    'header-text' => false,
));

//缩略图
add_theme_support( 'post-thumbnails' );

//添加公安备案
add_action('admin_init', 'mczo_gonganbeian');
function mczo_gonganbeian() {
    add_settings_field('mczo_gonganbeian_setting', '公安备案号', function(){echo '<input name="mczo_gonganbeian_setting" type="text" id="mczo_gonganbeian_setting" value="' . get_option('mczo_gonganbeian_setting') . '" class="regluar-text ltr">';}, 'general');
    register_setting('general','mczo_gonganbeian_setting');
}

//创建相册类型
function categoryBu()
{
    $labels = array(
        'name' => '相册',
        'add_new' => '新建相册',
        'search_items' => '搜索'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'excerpt')
    );
    register_post_type('bu', $args);
}
add_action('init', 'categoryBu');


//判断刚刚修改
function mczo_new_update($ptime) {
    $ptime = strtotime($ptime);
    if(time() - $ptime < 604800) return true; //7天前
    return false;
}

//404
function mczo_show_404() {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    exit;
}

//注册导航菜单
if (function_exists('register_nav_menus')) {
    register_nav_menus(array(
        'header-menu' => '导航菜单',
    ));
}

//自动添加暗箱标签属性
add_filter('the_content', 'pirobox_gall_replace', 98);
function pirobox_gall_replace($content)
{
    //添加lightbox
    $content = preg_replace("/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i", '<a$1href=$2$3.$4$5 data-rel="lightbox"$6>$7</a>', $content);
    //原生相册相关
    $content = preg_replace("/<div(.*?)id=('|\")(gallery.*?)('|\")(.*?)>/i", '<div$1id=$2$3$4$5 data-flex="wrap">', $content);
    $content = preg_replace("/<dl(.*?)class=('|\")(gallery-item)('|\")(.*?)>/i", '<dl$1class=$2$3$4$5 data-cell="row-lg-1/3 row-md-1/2 row-sm-1/2 row-xs-1">', $content);
    $content = preg_replace("/<br(.*?)style=('|\")(clear.*?)('|\")(.*?)>/i", '', $content);
    return $content;
}

//评论者的链接新窗口打开
function comment_author_link_window() {
    $url    = get_comment_author_url();
    $author = get_comment_author();
    return '<a href="'.$url.'"  target="_blank">'.$author.'</a>';
}
add_filter('get_comment_author_link', 'comment_author_link_window');


// 友情链接相关
add_action('admin_init', 'wpjam_blogroll_settings_api_init');
function wpjam_blogroll_settings_api_init() {
    add_settings_field('wpjam_blogroll_setting', '友情链接', function () {echo '<textarea name="wpjam_blogroll_setting" rows="10" cols="50" id="wpjam_blogroll_setting" class="large-text code">' . get_option('wpjam_blogroll_setting') . '</textarea>';}, 'reading');
    register_setting('reading','wpjam_blogroll_setting');
}

function wpjam_blogroll(){
    $wpjam_blogroll_setting =  get_option('wpjam_blogroll_setting');
    if($wpjam_blogroll_setting){
        $wpjam_blogrolls = explode("\n", $wpjam_blogroll_setting);
        shuffle($wpjam_blogrolls);
        echo '<ul data-flex="wrap">';
        foreach ($wpjam_blogrolls as $wpjam_blogroll) {
            $wpjam_blogroll = explode("|", $wpjam_blogroll );
            $image_url = strpos($wpjam_blogroll[2], 'http') ? $wpjam_blogroll[2] : 'https://cdn.v2ex.com/gravatar/' . md5(trim($wpjam_blogroll[2])) . '?s=96';
            echo '<li data-cell="row-xs-1/3 row-sm-1/6 row-md-1/6 row-lg-1/6"><a target="_blank" href="'.trim($wpjam_blogroll[0]).'" title="'.esc_attr(trim($wpjam_blogroll[1])).'"><img class="avatar" src="' . get_template_directory_uri() . '/dist/images/gravatar.jpg" data-src="' . $image_url . '" alt="' . trim($wpjam_blogroll[1]) . '" />'.$wpjam_blogroll[1].'</a></li>';
        }
        echo '</ul>';
    }
}

//文章摘要
function Bing_excerpt($length, $more = '&hellip;', $echo = true)
{
    static $excerpt_length, $excerpt_more;

    $current_filter = current_filter();
    if ($current_filter == 'excerpt_length') return $excerpt_length;
    if ($current_filter == 'excerpt_more') return $excerpt_more;

    $excerpt_length = $length;
    $excerpt_more = $more;

    $callable = __FUNCTION__;
    add_filter('excerpt_length', $callable, 18);
    add_filter('excerpt_more', $callable, 18);

    $excerpt = $echo ? the_excerpt() : get_the_excerpt();

    remove_filter('excerpt_length', $callable, 18);
    remove_filter('excerpt_more', $callable, 18);

    unset($excerpt_length, $excerpt_more);
    return $excerpt;
}

//发布时间
function timeago($ptime)
{
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return ' 刚刚';
    $interval = array(
        12 * 30 * 24 * 60 * 60 => ' 年前',
        30 * 24 * 60 * 60 => ' 个月前',
        7 * 24 * 60 * 60 => ' 周前',
        24 * 60 * 60 => ' 天前',
        60 * 60 => ' 小时前',
        60 => ' 分钟前',
        1 => ' 秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

//评论时间
function custom_comment_date( $date, $d, $comment ) {
    return '发表于 '.timeago(get_gmt_from_date($comment->comment_date));
}
add_filter( 'get_comment_date', 'custom_comment_date', 10, 3);

//删除评论时间
function custom_comment_time() {
    return null;
}
add_filter( 'get_comment_time', 'custom_comment_time');

//文章列表添加特色图像功能
function catch_that_image($width, $height, $link = true, $placeHold)
{
    global $post;
    $parent = get_post($post->post_parent);
    ob_start();
    ob_end_clean();
    if (has_post_thumbnail()) {
        $first_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0] . '?imageView2/1/w/' . $width . '/h/' . $height . '/interlace/0/q/100';
        if($link) return '<div class="list-img"><a href="' . get_permalink($parent) . '"><img src="'.$placeHold.'" alt="'.$post->post_name.'" data-src="' . $first_img . '"></a></div>';
        else return '<img class="bg" src="'.$placeHold.'" alt="'.$post->post_name.'" data-src="' . $first_img . '">';
    } else {
        return null;
    }
}

//评论框添加头像
add_filter('comment_form_top', 'show_gravatar');
function show_gravatar() {
    global $current_user;
    echo get_avatar( $current_user->user_email );  // 40是指头像的尺寸，第4步也一样
}

//评论@
function ludou_comment_add_at($comment_text, $comment = '')
{
    if ($comment->comment_parent > 0) {
        $comment_text = '<a href="#comment-' . $comment->comment_parent . '">@' . get_comment_author($comment->comment_parent) . '</a> ' . $comment_text;
    }

    return $comment_text;
}

add_filter('comment_text', 'ludou_comment_add_at', 20, 2);


//Wordpress 懒加载
function add_image_placeholders($content)
{
    if (false !== strpos($content, 'data-src'))
        return $content;
    $placeholder_image = 'data:image/png;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2NjIpLCBxdWFsaXR5ID0gNzAK/9sAQwAKBwcIBwYKCAgICwoKCw4YEA4NDQ4dFRYRGCMfJSQiHyIhJis3LyYpNCkhIjBBMTQ5Oz4+PiUuRElDPEg3PT47/9sAQwEKCwsODQ4cEBAcOygiKDs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7/8AAEQgAEQAeAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A9mooooAKKKKACiiigAooooA//9k=';
    $content = preg_replace('#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf('<img${1}src="%s" data-src="${2}"${3}>', $placeholder_image), $content);
    return $content;
}

add_filter('the_content', 'add_image_placeholders', 99);

//通过多说服务器加速Gravatar头像
function get_ssl_avatar($avatar)
{
    if(strpos($_SERVER['PHP_SELF'], 'admin-ajax.php') || !is_admin()) {
        $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/', '<img class="avatar" src="' . get_template_directory_uri() . '/dist/images/gravatar.jpg" data-src="https://cdn.v2ex.com/gravatar/$1?s=96">', $avatar);
    }
    return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

//------------------------------替换emoji----------------
function disable_emoji($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array(
            'wpemoji'
        ));
    } else {
        return array();
    }
}
//取当前主题下images\smilies\下表情图片路径
function custom_smilie_src($old, $img) {
    return get_stylesheet_directory_uri() . '/dist/smilies/' . $img;
}
function init_fixsmilie() {
    global $wpsmiliestrans;
    //默认表情文本与表情图片的对应关系(可自定义修改)
    $wpsmiliestrans = array(
        ':mrgreen:' => 'icon_mrgreen.png',
        ':neutral:' => 'icon_neutral.png',
        ':twisted:' => 'icon_twisted.png',
        ':arrow:' => 'icon_arrow.png',
        ':shock:' => 'icon_eek.png',
        ':smile:' => 'icon_smile.png',
        ':???:' => 'icon_confused.png',
        ':cool:' => 'icon_cool.png',
        ':evil:' => 'icon_evil.png',
        ':grin:' => 'icon_biggrin.png',
        ':idea:' => 'icon_idea.png',
        ':oops:' => 'icon_redface.png',
        ':razz:' => 'icon_razz.png',
        ':roll:' => 'icon_rolleyes.png',
        ':wink:' => 'icon_wink.png',
        ':cry:' => 'icon_cry.png',
        ':eek:' => 'icon_surprised.png',
        ':lol:' => 'icon_lol.png',
        ':mad:' => 'icon_mad.png',
        ':sad:' => 'icon_sad.png',
        '8-)' => 'icon_cool.png',
        '8-O' => 'icon_eek.png',
        ':-(' => 'icon_sad.png',
        ':-)' => 'icon_smile.png',
        ':-?' => 'icon_confused.png',
        ':-D' => 'icon_biggrin.png',
        ':-P' => 'icon_razz.png',
        ':-o' => 'icon_surprised.png',
        ':-x' => 'icon_mad.png',
        ':-|' => 'icon_neutral.png',
        ';-)' => 'icon_wink.png',
        '8O' => 'icon_eek.png',
        ':(' => 'icon_sad.png',
        ':)' => 'icon_smile.png',
        ':?' => 'icon_confused.png',
        ':D' => 'icon_biggrin.png',
        ':P' => 'icon_razz.png',
        ':o' => 'icon_surprised.png',
        ':x' => 'icon_mad.png',
        ':|' => 'icon_neutral.png',
        ';)' => 'icon_wink.png',
        ':!:' => 'icon_exclaim.png',
        ':?:' => 'icon_question.png',
    );
    //移除WordPress4.2版本更新所带来的Emoji钩子同时挂上主题自带的表情路径
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emoji');
    add_filter('smilies_src', 'custom_smilie_src', 10, 2);
}
add_action('init', 'init_fixsmilie', 5);

//-----------------------------邮件------------------
//--------smtp------------
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp($phpmailer)
{
    $phpmailer->FromName = '帅健博客'; //发件人的名称
    $phpmailer->Host = 'smtpdm.aliyun.com'; //修改为你使用的SMTP服务器
    $phpmailer->Port = 465; //SMTP端口
    $phpmailer->Username = 'postmaster@mczo.net'; //你的邮箱账号
    $phpmailer->Password = ''; //邮箱密码
    $phpmailer->From = 'postmaster@mczo.net'; //你的邮箱账号
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = 'ssl'; //ssl对应的端口465
    $phpmailer->IsSMTP();
}

//邮件回复
function comment_mail_notify($comment_id)
{
    $admin_email = get_bloginfo('admin_email');
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email)) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $subject = '您在 [' . get_option("blogname") . '] 的留言有了新回复';
        $message = '
    <div style="background-color:#fff; color:#222; font-size:14px; width:100%; padding: 0 15px;">
	    <div style="width:100%; height:60px;">
	    	<h1 style="text-align:center; font-size:1.5em; font-weight:500;">您在<a href="' . home_url() . '" style="text-decoration:none; font-weight:600; color:#333;"> [' . get_option("blogname") . '] </a>上的留言有回复啦！</h1>
	    </div>
	    <div style="width:90%; margin:0 auto">
	      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
	      <p>您在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />
	      <p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">' . trim(get_comment($parent_id)->comment_content) . '</p>
	      <p>' . trim($comment->comment_author) . ' 给你的回复:<br />
	      <p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">' . trim($comment->comment_content) . '</p>
	      <p>你可以点击<a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看完整内容</a></p>
	      <p>欢迎再度光临<a href="' . home_url() . '">' . get_option('blogname') . '</a></p>
	      <p>(此邮件由系统自动发出, 请勿回复。)</p>
	    </div>
    </div>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}

add_action('comment_post', 'comment_mail_notify');

//-----------------------------禁用资源------------------------
//禁用gallery样式
add_filter('use_default_gallery_style', '__return_false');

//禁用响应式图片
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );

// 去除头部不必要信息
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('wp_head', 'rel_canonical');
//移除菜单的多余CSS选择器
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
    return is_array($var) ? array_intersect($var, array('current-menu-item','menu-item-has-children')) : '';
}
//禁用embeds功能
if (!function_exists('disable_embeds_init')) :
    function disable_embeds_init()
    {
        global $wp;
        $wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
        remove_action('rest_api_init', 'wp_oembed_register_route');
        add_filter('embed_oembed_discover', '__return_false');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    }

    add_action('init', 'disable_embeds_init', 9999);

    function disable_embeds_tiny_mce_plugin($plugins)
    {
        return array_diff($plugins, array('wpembed'));
    }

    function disable_embeds_rewrites($rules)
    {
        foreach ($rules as $rule => $rewrite) {
            if (false !== strpos($rewrite, 'embed=true')) {
                unset($rules[$rule]);
            }
        }
        return $rules;
    }

    function disable_embeds_remove_rewrite_rules()
    {
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        flush_rewrite_rules();
    }

    register_activation_hook(__FILE__, 'disable_embeds_remove_rewrite_rules');

    function disable_embeds_flush_rewrite_rules()
    {
        remove_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        flush_rewrite_rules();
    }

    register_deactivation_hook(__FILE__, 'disable_embeds_flush_rewrite_rules');
endif;

//ajax评论提交
function fa_ajax_comment_callback(){
    $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $data = intval( $comment->get_error_data() );
        if ( ! empty( $data ) ) {
            wp_die( '<p>' . $comment->get_error_message() . '</p>',  'Comment Submission Failure' , array( 'response' => $data, 'back_link' => true ) );
        } else {
            exit;
        }
    }
    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);

    if ( empty( $_REQUEST['comment_post_ID'] ) ) {
        die();
    }

    query_posts( array( 'p' => $_REQUEST['comment_post_ID'], 'post_type' => 'any' ) );
    if ( have_posts() ) {
        the_post();
        comments_template('/template-parts/comment/list.php');
        exit();
    }

    die();
}
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');

//ajax载入评论
add_action('wp_ajax_nopriv_load_comment', 'retrieve_comments');
add_action('wp_ajax_load_comment', 'retrieve_comments');
function retrieve_comments(){
    if ( empty( $_REQUEST['post_id'] ) ) {
        die();
    }

    query_posts( array( 'p' => $_REQUEST['post_id'], 'post_type' => 'any' ) );
    if ( have_posts() ) {
        the_post();
        comments_template('/template-parts/comment/ajax.php');
        exit();
    }

    die();
};

//关键字为空跳转首页
function c7sky_redirect_blank_search( $query_variables ) {
    if ( isset( $_GET['s'] ) && empty( $_GET['s']) ) {
        wp_redirect( home_url() );
        exit;
    }
    return $query_variables;
}
add_filter( 'request', 'c7sky_redirect_blank_search' );

//自定义文章显示数量
function custom_posts_per_page($query){
    if(is_post_type_archive('bu')) $query->set('posts_per_page',10);
}
add_action('pre_get_posts','custom_posts_per_page');
