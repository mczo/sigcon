<?php get_header(); ?>

<div id="page-box" class="padding-box page-single add-border">
    <?php
    while ( have_posts() ) : the_post();
        if( has_post_format( 'gallery' ) ){
            get_template_part('template-parts/post/content', 'gallery');
        } else {
            get_template_part('template-parts/post/content');
        }
    endwhile;
    ?>
</div>

<?php
if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>

<?php get_footer(); ?>