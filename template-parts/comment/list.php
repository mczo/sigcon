<?php
if (post_password_required()) {
    return;
}
?>

<div>

        <ul id="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ul',
                'short_ping'  => true,
            ) );
            ?>
        </ul>

</div>