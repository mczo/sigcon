<?php

/**
 *
 *Template Name: 归档
 *
 * @package WordPress
 * @subpackage sigcon
 * @since sigcon 1.0
 */


get_header(); ?>

    <div id="page-box" class="padding-box page-classification add-border">
        <?php
        while ( have_posts() ) : the_post();get_template_part( 'template-parts/post/content', 'classification' );
        endwhile;
        ?>
    </div>

<?php get_footer(); ?>