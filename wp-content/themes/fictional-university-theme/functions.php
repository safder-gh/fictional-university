<?php
require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');
function university_custom_rest()
{
    register_rest_field('post', 'author_name', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));
    register_rest_field('note', 'user_note_count', array(
        'get_callback' => function () {
            return count_user_posts(get_current_user_id(), 'note');
        }
    ));
}
add_action('rest_api_init', 'university_custom_rest');
function pageBanner($args = null)
{
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle') ? get_field('page_banner_subtitle') : 'n/a';
    }
    if (!$args['image']) {
        $pageBannerBackgroundImage = get_field('page_banner_background_image');
        if ($pageBannerBackgroundImage) {
            $args['image'] = $pageBannerBackgroundImage['sizes']['pageBanner'];
        } else {
            $args['image'] = get_theme_file_uri('images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['image']; ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'];
                    ?></p>
            </div>
        </div>
    </div>
<?php
}
function university_files()
{
    wp_enqueue_script('fictional-university-js', get_theme_file_uri('/js/scripts-bundled.js'), null, microtime(), true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_style', get_stylesheet_uri(), null, microtime());
    wp_localize_script('fictional-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}
add_action('wp_enqueue_scripts', 'university_files');
function university_features()
{
    // register_nav_menu('HeaderMenuLocation', 'Header Menu Location');
    // register_nav_menu('FooterLocationOne', 'Footer Location One');
    // register_nav_menu('FooterLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}
add_action('after_setup_theme', 'university_features');
function university_adjust_query($query)
{
    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'asc');
        $query->set('posts_per_page', -1);
    }
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'asc');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => date('Ymd'),
                'type' => 'numeric',
            ),
        ));
    }
    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    }
}
add_action('pre_get_posts', 'university_adjust_query');

function universityMapKey($api)
{
    $api['key'] = 'AIzaSyB_lxt2dtbXU8ld1Cn6eSL0vH_zjM2SmF8';
    return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');
//AIzaSyB_lxt2dtbXU8ld1Cn6eSL0vH_zjM2SmF8

add_action('admin_init', function () {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
});
add_action('wp_loaded', function () {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
});

add_filter('login_headerurl', function () {
    return site_url('/');
});

add_action('login_enqueue_scripts', function () {
    wp_enqueue_style('university_main_style', get_stylesheet_uri(), null, microtime());
});

add_filter('login_headertitle', function () {
    return get_bloginfo('name');
});

add_filter('wp_insert_post_data', function ($data, $postarr) {
    if ($data['post_type'] == 'note') {
        if (count_user_posts(get_current_user_id(), 'note') > 4 && !$postarr['ID']) {
            die('You have reach your posts limit.');
        }
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }
    if ($data['post_type'] == 'note' && $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }
    return $data;
}, 10, 2);

add_filter('posts_where', function ($where) {
    return $where;
});
