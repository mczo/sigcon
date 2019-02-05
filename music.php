<?php
/**
 *
 *Template Name: 歌单
 *
 * @package WordPress
 * @subpackage sigcon
 * @since sigcon 1.0
 */
get_header(); ?>


    <div id="page-box" class="padding-box page-music add-border">
        <?php
        while ( have_posts() ) : the_post();get_template_part( 'template-parts/post/content', 'music' );
        endwhile;
        ?>
    </div>

<?php get_footer(); ?>