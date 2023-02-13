<?php
get_header();
while (have_posts()) {
    the_post();
    pageBanner();
?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programs</a>
                <span class="metabox__main">Posted By <?php the_author_posts_link(); ?> on <?php the_time('d M-Y') ?> in <?php echo get_the_category_list(', '); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_field('main_body_content') ?>
            <?php
            $relatedProfessors = new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'professor',
                'orderby' => 'title',
                'order' => 'asc',
                'meta_query' => array(
                    array(
                        'key' => 'related_programs',
                        'compare' => 'like',
                        'value' => '"' . get_the_ID() . '"',
                    ),
                ),
            ));
            if ($relatedProfessors->have_posts()) {
                echo '<hr class="section-break">';
                echo '<h3 class="headline headline--medium">' . get_the_title() . ' Professor(s)</h3>';
                echo '<ul class="professors-card">';
                while ($relatedProfessors->have_posts()) {
                    $relatedProfessors->the_post();
            ?>
                    <li class="professor-card__list-item">
                        <a class="professor-card" href="<?php the_permalink(); ?>">
                            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
                            <span class="professor-card__name"><?php the_title(); ?></span>

                        </a>
                    </li>
                <?php
                }
                echo '</ul>';
            }
            wp_reset_postdata();

            $customPageEvents = new WP_Query(array(
                'posts_per_page' => 2,
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'asc',
                'meta_query' => array(
                    array(
                        'key' => 'event_date',
                        'compare' => '>=',
                        'value' => date('Ymd'),
                        'type' => 'numeric',
                    ),
                    array(
                        'key' => 'related_programs',
                        'compare' => 'like',
                        'value' => '"' . get_the_ID() . '"',
                    ),
                ),
            ));
            if ($customPageEvents->have_posts()) {
                echo '<hr class="section-break">';
                echo '<h3 class="headline headline--medium">Upcoming ' . get_the_title() . ' Event(s)</h3>';
                while ($customPageEvents->have_posts()) {
                    $customPageEvents->the_post();
                    get_template_part('/template-parts/content', 'event');
                }
            }
            wp_reset_postdata();

            $relatedCampuses = get_field('related_campuses');
            if ($relatedCampuses) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">' . get_the_title() . ' is available on these campuses</h2>';
                echo '<ul class="min-list link-list">';
                foreach ($relatedCampuses as $campus) {
                ?>
                    <li><a href="<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus); ?></a></li>
            <?php
                }
                echo '</ul>';
            }

            ?>
        </div>
    </div>
<?php
}
get_footer();
?>