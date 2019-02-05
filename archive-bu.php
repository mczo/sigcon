<?php get_header(); ?>

    <div id="list-continue" class="cloth-list-box" data-flex="wrap">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/list/list', 'cloth' );
            endwhile;
            the_posts_pagination();
        endif;
        ?>
    </div>

<?php get_footer(); ?>