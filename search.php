<?php get_header(); ?>
    <header class="child-page-header">
        <?php if ( have_posts() ) : ?>
            <h1><?php printf( ( '“ %s ” 的搜索结果：' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        <?php else : ?>
            <h1><?php printf( ( '抱歉，没有找到与 “ %s ” 相符的内容或信息。' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        <?php endif; ?>
    </header>

    <div id="list-continue" class="search-list-box" data-flex="wrap">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/list/list', 'search' );
            endwhile;
            the_posts_pagination(array(
                'next_text' => '加载更多'
            ));
        endif; ?>
    </div>

<?php get_footer(); ?>