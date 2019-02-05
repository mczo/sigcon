<?php get_header(); ?>
    <?php if ( have_posts() ) : ?>
        <header class="child-page-header">
            <?php
            the_archive_title( '<h1>', '</h1>' );
            the_archive_description( '<div class="description">', '</div>' );
            ?>
        </header>
    <?php endif; ?>

    <div id="list-continue" class="index-list-box">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                if( has_post_format( 'gallery' ) ) get_template_part( 'template-parts/list/list', 'gallery' );
                else get_template_part( 'template-parts/list/list', 'default' );
            endwhile;
            the_posts_pagination(array(
                'next_text' => '加载更多'
            ));
        else :
            get_template_part( 'template-parts/post/content', 'none' );
        endif;
        ?>
    </div>

<?php get_footer(); ?>