<section <?php post_class(); ?>>
    <header class="text-center">
        <?php the_title('<h1>', '</h1>'); ?>
        <div class="meta-box">
            <span><?php echo'最后修改于 '.timeago(get_gmt_from_date(get_the_modified_time('Y-m-d G:i:s'))); ?></span>
            <span class="meta-box"><a href="<?php echo get_post_type_archive_link( get_post_type() ) ?>"><?php echo get_post_type_object( get_post_type($post) )->label ?></a></span>
        </div>
    </header>

    <div id="page-content">
        <?php the_content(); ?>
    </div>
</section>