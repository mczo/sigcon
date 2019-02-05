<section <?php post_class(); ?>>
    <header class="text-center">
        <?php the_title('<h1>', '</h1>'); ?>
    </header>

    <div id="links-list">
        <?php wpjam_blogroll();?>
    </div>

    <div id="page-content">
        <?php the_content(); ?>
    </div>
</section>