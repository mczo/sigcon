<section>
    <header>
        <?php the_title('<h1 class="text-center">', '</h1>'); ?>
    </header>

    <main id="zhuifan">
        <ul data-flex="wrap">
            <?php
            $filename = "";
            $json_string = file_get_contents($filename);

            //$json_string = utf8_encode($json_string);
            $obj=json_decode($json_string,true);
            if (!is_array($obj)) {
                die('no successful');
            } else {
                foreach ($obj as $key){
                    echo '<li data-cell="row-xs-1/2 row-sm-1/2 row-md-1/3 row-lg-1/4"><a href="'.$key['href'].'" target="_blank" rel="nofollow"><img src="' . get_template_directory_uri() . '/dist/images/placeholder.jpg?imageMogr2/auto-orient/thumbnail/x300/gravity/Center/crop/200x300/format/jpg/blur/1x0/quality/100
" data-src="'.$key['image'].'" alt="'.$key['title'].'">'.$key['title'].'</a></li>';
                }
            }
            ?>
        </ul>
    </main>
</section>