<?php
get_header();
$args = array(
    'title' => 'Past Events',
    'subtitle' => 'Whats happening around us',
);
pageBanner($args);
?>

<div class="container container--narrow page-section">
    <?php
    $pastPageEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'asc',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '<',
                'value' => date('Ymd'),
                'type' => 'numeric',
            ),
        ),
    ));
    while ($pastPageEvents->have_posts()) {
        $pastPageEvents->the_post();
        $eventDate = new DateTime(get_field('event_date'));
        get_template_part('/template-parts/content', 'event');
    }
    echo paginate_links(array(
        'total' => $pastPageEvents->max_num_pages,
    ));
    wp_reset_postdata();

    ?>
</div>
<?php
get_footer();
?>