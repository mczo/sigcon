<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments">

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? ' required="true"' : '' );
    $smile_url = get_template_directory_uri() . '/dist/smilies/';

    comment_form(array(
        'comment_notes_before' => null,
        'comment_notes_after' => null,
        'logged_in_as' => null,
        'title_reply'       => null,
        'title_reply_to' => '正在回复 %s',
        'comment_field' => '<div data-cell="row-1" id="comment-box">
                                <textarea placeholder="说些感想吧……" id="comment" name="comment" rows="6" maxlength="200" ' . $aria_req . '></textarea>
                                <div class="emoji-buttom hidden-md">
                                    <svg class="icon icon-smile"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-smile"></use><symbol id="icon-smile" viewBox="0 0 32 32"><path d="M16 32c8.837 0 16-7.163 16-16s-7.163-16-16-16-16 7.163-16 16 7.163 16 16 16zM16 3c7.18 0 13 5.82 13 13s-5.82 13-13 13-13-5.82-13-13 5.82-13 13-13zM8 10c0-1.105 0.895-2 2-2s2 0.895 2 2c0 1.105-0.895 2-2 2s-2-0.895-2-2zM20 10c0-1.105 0.895-2 2-2s2 0.895 2 2c0 1.105-0.895 2-2 2s-2-0.895-2-2zM22.003 19.602l2.573 1.544c-1.749 2.908-4.935 4.855-8.576 4.855s-6.827-1.946-8.576-4.855l2.573-1.544c1.224 2.036 3.454 3.398 6.003 3.398s4.779-1.362 6.003-3.398z"></path></symbol></svg>
                                    <div class="emoji-box add-shadow" data-flex="wrap">
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_mrgreen.png" alt=":mrgreen:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_neutral.png" alt=":neutral:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_twisted.png" alt=":twisted:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_arrow.png" alt=":arrow:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_eek.png" alt=":shock:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_smile.png" alt=":smile:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_confused.png" alt=":???:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_lol.png" alt=":lol:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_biggrin.png" alt=":grin:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_idea.png" alt=":idea:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_cool.png" alt=":cool:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_razz.png" alt=":razz:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_sad.png" alt=":sad:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_wink.png" alt=":wink:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_cry.png" alt=":cry:"></span>
                                        <span data-cell="row-1/4"><img src="'. $smile_url . 'icon_surprised.png" alt=":eek:"></span>
                                    </div>
                                </div>
                            </div>',
        'fields' => array(
            'author' =>
                '<input data-cell="row-input" placeholder="昵称' . ( $req ? '（必填）' : '' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />',

            'email' =>
                '<input data-cell="row-input" placeholder="电子邮件' . ( $req ? '（必填）' : '' ) . '" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />',

            'url' =>
                '<input data-cell="row-input" placeholder="网址" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />',
        ),
    ));


    if (have_comments()) : ?>

        <ul id="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ul',
                'short_ping'  => true,
            ) );
            ?>

            <?php the_comments_pagination(array(
                'prev_text' => '加载更多',
            ));
            ?>
        </ul>

    <?php endif; ?>

</div>