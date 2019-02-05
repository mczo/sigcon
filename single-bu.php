<?php get_header(); ?>

<div id="page-box" class="padding-box page-single add-border">
    <?php
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/post/content', 'bu' );
    endwhile;
    ?>
</div>

<?php get_footer(); ?>