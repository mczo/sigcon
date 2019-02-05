<?php
if(extension_loaded('zlib')){//检查是否开启zlib
    ob_start('ob_gzhandler');
}
header('Content-type: text/css');
header('cache-control: must-revalidate');
$offset = 60 * 60 * 24 * 7;//css文件的距离现在的过期时间，这里设置为一天
$expire = 'expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT';
header($expire);
ob_start("compress");
function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

/* your css files */
include('re.css');
include('flex.css');
include('index.css');
include ('lightbox.css');
include ('music.css');

if(extension_loaded('zlib')){
    ob_end_flush();//输出buffer中的内容，即压缩后的css文件
}