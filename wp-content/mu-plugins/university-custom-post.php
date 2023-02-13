<?php
function university_post_types()
{
    register_post_type('campus', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'campuses'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Campuses',
            'add_new_item' => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus',
        ),
        'menu_icon' => 'dashicons-location-alt',
    ));

    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event',
        ),
        'menu_icon' => 'dashicons-calendar',
    ));
    register_post_type('program', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Program',
            'singular_name' => 'Program',
        ),
        'menu_icon' => 'dashicons-money',
    ));
    register_post_type('professor', array(
        'supports' => array('title',  'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'Professor',
            'add_new_item' => 'Add New Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor',
        ),
        'menu_icon' => 'dashicons-welcome-learn-more',
    ));
    register_post_type('note', array(
        'capability_type' => 'note',
        'map_meta_cap' => 'true',
        'supports' => array('title', 'editor'),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Note',
            'add_new_item' => 'Add New Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note',
        ),
        'menu_icon' => 'dashicons-welcome-write-blog',
    ));
    register_post_type('like', array(
        'capability_type' => 'like',
        'map_meta_cap' => 'true',
        'supports' => array('title', 'author', 'liked_professor_id'),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Like',
            'add_new_item' => 'Add New Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like',
        ),
        'menu_icon' => 'dashicons-heart',
    ));
}
add_action('init', 'university_post_types');
