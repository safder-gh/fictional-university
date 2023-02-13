<?php
get_header();
while (have_posts()) {
    the_post();
    $args = array(
        'title' => get_the_title(),
        'subtitle' => get_field('page_banner_subtitle'),
        'image' => 'https://bookmepk.s3.eu-central-1.amazonaws.com/static/images/blogs/s68bm0y9Mr4Upm6YsIAbDxKoBnoeSHdobEHMjeoN.jpg',
    );
    pageBanner($args);
?>
    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail('professorPortrait'); ?></div>
                <div class="two-third">
                    <?php
                    $existStatus = 'no';
                    $likeCount = new WP_Query(
                        array(
                            'post_type' => 'like',
                            'meta_query' => array(
                                array(
                                    'key' => 'liked_professor_id',
                                    'compare' => '=',
                                    'value' => get_the_ID(),
                                    'type'      => 'NUMERIC',
                                ),
                            ),
                        ),
                    );
                    if (is_user_logged_in()) {
                        $alreadyExist = new WP_Query(
                            array(
                                'author' => get_current_user_id(),
                                'post_type' => 'like',
                                'meta_query' => array(
                                    array(
                                        'key' => 'liked_professor_id',
                                        'compare' => '=',
                                        'value' => get_the_ID(),
                                        'type'      => 'NUMERIC',
                                    ),
                                ),
                            ),
                        );
                        if ($alreadyExist->found_posts) {
                            $existStatus = 'yes';
                        }
                    }

                    ?>
                    <span class="like-box" data-like="<?php echo $alreadyExist->posts[0]->ID; ?>" data-professor="<?php echo the_id(); ?>" data-exists="<?php echo $existStatus; ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                    </span>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <hr class="section-break">
        <?php
        $relatedPrograms = get_field('related_programs');
        if ($relatedPrograms != null) {
            echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedPrograms as $program) {
        ?>
                <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
        <?php
                echo '</ul>';
            }
        }

        //print_r($relatedPrograms);
        ?>

    </div>
<?php
}
get_footer();
?>