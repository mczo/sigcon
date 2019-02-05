<?php
if(extension_loaded('zlib')){//检查是否开启zlib
    ob_start('ob_gzhandler');
}
require 'jsmin.php';
header('Content-type: text/javascript');
header('cache-control: must-revalidate');
$offset = 60 * 60 * 24 * 7;//css文件的距离现在的过期时间，这里设置为一天
$expire = 'expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT';
header($expire);
ob_start("compress");
function compress() {
    $buffer = JSMin::minify(
        file_get_contents('jquery-3.2.1.min.js') .
        file_get_contents('lazyload.js') .
        file_get_contents('headroom.min.js') .
        file_get_contents('ajax-load.js') .
        file_get_contents('music.js') .
        file_get_contents('lightbox.js') .
        file_get_contents('md5.js') .
        file_get_contents('comment-reply.min.js') .
        file_get_contents('index.js')
    );
    return $buffer;
}

if(extension_loaded('zlib')){
    ob_end_flush();//输出buffer中的内容，即压缩后的css文件
}