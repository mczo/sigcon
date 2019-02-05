<section>
    <header>
        <?php the_title('<h1 class="text-center">', '</h1>'); ?>
    </header>

    <main id="musiclist">
        <ul>
            <?php
            $filename = "";
            $json_string = file_get_contents($filename);
            $music_id = 0;
            //$json_string = utf8_encode($json_string);
            $obj=json_decode($json_string,true);
            if (!is_array($obj)) {
                die('no successful');
            } else {
                foreach ($obj as $key){
                    echo '<li data-musicid="'.$music_id.'">'.($music_id + 1).'. '.$key['name'].'</li>';
                    $music_id++;
                }
            }
            ?>
        </ul>
    </main>
</section>