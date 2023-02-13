<?php
if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
}
get_header();
while (have_posts()) {
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="create-note">
            <h2 class="headline headline--medium">Create New Note</h2>
            <input type="text" class="new-note-title" placeholder="Title">
            <textarea class="new-note-body" placeholder="Your note here.."></textarea>
            <span class="submit-note">Create Note</span>
            <span class="note-limit-message">Note limit reached: delete an existing note to make for new one.</span>
        </div>
        <ul class="min-list link-list" id="my-notes">
            <?php
            $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => '-1',
                'author' => get_current_user_id(),
            ));
            while ($userNotes->have_posts()) {
                $userNotes->the_post();
            ?>
                <li data-status="readonly" data-id="<?php the_ID(); ?>">
                    <input readonly class="note-title-field" type="text" value="<?php echo esc_attr(get_the_title()); ?>">
                    <span class="edit-note" aria-hidden="true">
                        <i class="fa fa-pencil"></i>
                        Edit
                    </span>
                    <span class="delete-note" aria-hidden="true">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </span>
                    <textarea readonly class="note-body-field"><?php echo esc_attr(get_the_content()); ?></textarea>
                    <span class="update-note btn btn--blue btn--small" aria-hidden="true">
                        <i class="fa fa-arrow-right"></i>
                        Save
                    </span>

                </li>
            <?php
            }
            ?>
        </ul>
    </div>


<?php
}
get_footer();
?>