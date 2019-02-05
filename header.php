<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style type="text/css">#open-loading{position:fixed;z-index:9999;width:100%;height:100%;left:0;top:0;background:#fff;opacity:1;transition:opacity .5s ease,visibility .5s ease}#open-loading.hides{opacity:0;visibility:hidden}.loader{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%)}.loader h1{font-size:20px;color:#666;margin-bottom:10px}.loader span{width:16px;height:16px;display:inline-block;border-radius:50%;position:absolute;left:50%;transform:translate3d(-50%,0,0)}.loader span:nth-child(2){background:#a8d8b9;animation:twoloading 1.2s infinite linear}.loader span:nth-child(3){background:#fedfe1;z-index:1}.loader span:nth-child(4){background:#f596aa;animation:oneloading 1.2s infinite linear}@keyframes oneloading{0%{transform:translate3d(-250%,0,0);z-index:2}50%{transform:translate3d(150%,0,0)}100%{transform:translate3d(-250%,0,0)}}@keyframes twoloading{0%{transform:translate3d(150%,0,0)}50%{transform:translate3d(-250%,0,0)}100%{transform:translate3d(150%,0,0);z-index:2}}</style>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page">
    <div id="open-loading"><div class="loader"><h1>Loading…</h1><span></span><span></span><span></span></div></div>
    <div id="header-box">
        <header id="navbar-box" data-flex="main-center">
            <div data-flex="container cross-center main-between">
                <div id="buttom-flex" class="visible-md">
                    <div id="navbar-buttom-box" data-flex="cross-center">
                        <div id="navbar-buttom" data-flex="wrap between">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>

                <?php wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container' => 'nav',
                    'menu_id' => 'navbar-list',
                ));
                ?>

                <div style="padding-left: .4rem;">
                    <div id="search-buttom-box">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div id="content" data-flex="col">
        <span class="kongbai"></span>
        <div id="content-main" data-flex="main-center" data-cell>
            <div id="var-box" data-flex="container col">
