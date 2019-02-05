<?php

/**
 *
 *Template Name:  友情链接
 *
 * @package WordPress
 * @subpackage sigcon
 * @since sigcon 1.0
 */


get_header(); ?>

<div id="page-box" class="padding-box page-links add-border">
    <?php
    while ( have_posts() ) : the_post();get_template_part( 'template-parts/post/content', 'links' );
    endwhile;
    ?>
</div>

<?php
if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>

<?php get_footer(); ?>