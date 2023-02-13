<?php
get_header();
$args = array(
    'title' => 'All Programs',
    'subtitle' => 'There is something for every one.',
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