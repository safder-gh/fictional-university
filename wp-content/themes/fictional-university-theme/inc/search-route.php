<?php
function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'universitySearchResult',
    ));
}
add_action('rest_api_init', 'universityRegisterSearch');
function universitySearchResult($args)
{
    $mainQuery = new WP_Query(
        array(
            'post_type' => array('post', 'page', 'professor', 'campus', 'event', 'program'),
            's' => sanitize_text_field($args['term'])
        ),
    );
    $result =  array(
        'general_info' => array(),
        'professors' => array(),
        'campuses' => array(),
        'events' => array(),
        'programs' => array(),
    );
    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();
        if (get_post_type() == 'post' || get_post_type() == 'page') {
            array_push($result['general_info'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'post_type' => get_post_type(),
                'author_name' => get_the_author(),
            ));
        } else if (get_post_type() == 'professor') {
            array_push($result['professors'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'image_url' => get_the_post_thumbnail_url(0, 'professorLandscape'),
            ));
        } else if (get_post_type() == 'campus') {
            array_push($result['campuses'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink(),
            ));
        } else if (get_post_type() == 'event') {
            array_push($result['events'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink(),
            ));
        } else if (get_post_type() == 'program') {
            array_push($result['programs'], array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_the_permalink(),
            ));
        }
    }
    if ($result['programs']) {
        $programMetaQuery = array('relation' => 'or');

        foreach ($result['programs'] as $item) {
            array_push($programMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            ));
        }
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'meta_query' => $programMetaQuery,

        ));
        while ($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();
            if (get_post_type() == 'event') {
                array_push($result['events'], array(
                    'title' => get_the_title(),
                    'link' => get_the_permalink(),
                ));
            }
            if (get_post_type() == 'professor') {
                array_push($result['professors'], array(
                    'title' => get_the_title(),
                    'link' => get_the_permalink(),
                    'image_url' => get_the_post_thumbnail_url(0, 'professorLandscape'),
                ));
            }
        }

        $result['professors'] = array_unique($result['professors'], SORT_REGULAR);
        $result['professors']  = array_values($result['professors']);

        $result['events'] = array_unique($result['events'], SORT_REGULAR);
        $result['events']  = array_values($result['events']);
    }
    return $result;
}
