<article data-cell="row-lg-1/2 row-md-1/2 row-sm-1/2 row-xs-1">
        <div class="list-header add-border show-shadow" data-flex="cross-center main-between">
            <div>
                <h2 class="base-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                <div class="meta-box">
                    <span><time datetime="<?php the_time('Y-m-d'); ?>"><?php echo'发表于 '.timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s'))); ?></time></span>
                    <span><?php comments_popup_link('无回复', '1 回复', '% 回复', '', '回复已关闭'); ?></span>
                </div>
            </div>
            <div class="list-header-category">
                <span><?php the_category('，'); ?></span>
            </div>
        </div>
</article>