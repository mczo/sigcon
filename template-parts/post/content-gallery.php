<section <?php post_class(); ?>>
    <header class="text-center">
        <?php the_title('<h1>', '</h1>'); ?>
        <?php if (is_single()) : ?>
            <div class="meta-box">
                <span><time class="moden-title" datetime="<?php the_time('Y-m-d'); ?>" title="<?php the_time('Y-m-d'); ?>"><?php echo'发表于 '.timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s'))); ?></time></span>
                <span><?php the_category('，'); ?></span>
            </div>
        <?php endif; ?>
    </header>

    <div id="page-content">
        <?php the_content(); ?>
    </div>

    <?php the_tags('<footer class="text-center" id="single-tag"><div>Tags</div>', null, '</footer>'); ?>
</section>