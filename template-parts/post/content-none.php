<section id="not-found" class="padding-box">
    <header>
        <h1 class="text-center">
            <?php
                if (is_404())
                    echo '404 Not Found.';
                else
                    echo '抱歉，没有找到你所需要的文章';
            ?>
        </h1>
    </header>
</section>