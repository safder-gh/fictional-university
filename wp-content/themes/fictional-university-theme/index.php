<?php
get_header();
$args = array(
    'title' => 'Welcome to our blog!',
    'subtitle' => 'keep up to date  with latest news',
);
pageBanner($args);
?>
<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post();
    ?>
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="metabox">
                Posted By <?php the_author_posts_link(); ?> on <?php the_time('d M-Y') ?> in <?php echo get_the_category_list(', '); ?>
            </div>
            <div class="generic-content">
                <?php the_excerpt(); ?>
                <p><a class="btn btn--blue" href="<?php the_Permalink(); ?>">Continue Reading &raquo;</a></p>
            </div>
        </div>
    <?php
    }
    echo paginate_links();
    ?>
</div>
<?php
get_footer();
?>