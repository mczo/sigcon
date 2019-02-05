<section>
    <header>
        <?php the_title('<h1 class="text-center">', '</h1>'); ?>
    </header>

    <main id="classification-content">
        <div class="classification">
            <h2>分类目录</h2>
            <ul data-flex="wrap">
                <?php
                wp_list_categories( array(
                    'orderby'            => 'name',
                    'title_li'           => null,
                ) );
                ?>
            </ul>
        </div>

        <div class="tags">
            <h2>标签目录</h2>
            <?php wp_tag_cloud( array(
                'smallest'   => 1,
                'largest'    => 1,
                'unit'       => 'rem',
                'number'     => 0,
                'format'     => '',
                'separator'  => '',
                'orderby'    => 'count',
                'order'      => 'RAND',
            ) ); ?>
        </div>

        <div class="archives">
            <?php
            $previous_year = $year = 0;
            $previous_month = $month = 0;
            $ul_open = false;
            $myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
            foreach ($myposts as $post) :
                setup_postdata($post);
                $year = mysql2date('Y', $post->post_date);
                $month = mysql2date('n', $post->post_date);
                $day = mysql2date('j', $post->post_date);
                if ($year != $previous_year || $month != $previous_month) :
                    if ($ul_open == true) :
                        echo '</ul>';
                    endif;
                    echo '<h4 class="list-title">';
                    if(get_the_time("Y") == date("Y")) {
                        the_time("n月");
                    } else {
                        the_time("Y年n月");
                    }
                    echo '</h4>';
                    echo '<ul>';
                    $ul_open = true;
                endif;
                $previous_year = $year;
                $previous_month = $month;
                ?>
                <li>
                    <span><?php the_time('m-d'); ?></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
            <?php endforeach; ?>
        </div>
    </main>
</section>