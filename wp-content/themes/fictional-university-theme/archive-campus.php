<?php
get_header();
$args = array(
    'title' => 'All Campuses',
    'subtitle' => 'Location of all campuses.',
);
pageBanner($args);
?>
<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        <?php
        while (have_posts()) {
            the_post();
        ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php
        }
        ?>
    </ul>
    <?php
    echo paginate_links();
    ?>
</div>
<?php
get_footer();
?>