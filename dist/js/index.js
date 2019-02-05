$(document).ready(function () {
    mczolightbox = new lightbox('a[data-rel="lightbox"]');
    mczolightbox.start();
    mczoplayer = new mczoplayer();
    mczoplayer.start();
    lazyLoad = new LazyLoad();
    lazyLoad.fresh();

    navBar();
    gotoTop();

    mczoLoadInFun();
});

//导航条
function navBar() {
    let $navbar_box = $('#navbar-box');
    //headroom
    new Headroom($navbar_box[0], {
        offset : $('span.kongbai').height() - $navbar_box.height()
    }).init();

    navbar_li.click(() => {
        $navbar_box.removeClass("active");
    });

    $('#navbar-buttom').click(() => {
        $navbar_box.toggleClass('active');
    });
}

//回顶部
function gotoTop() {
    let $goto_top = $("#goto-top");
    $goto_top.click(function () {
        mczo_scroll.top();
        return false;
    });

    new Headroom($goto_top[0]).init();
}

//评论
topmain
    .on('click', '.emoji-box span', function () {
        let cminput = $("textarea#comment");
        let text = ' ' + $(this).find("img").attr("alt") + ' ';
        let vals = cminput.val() + text;
        cminput.val('').focus().val(vals);
    })
    .on('blur', 'input#email[data-cell="row-input"]', function () {
        let $email = $(this).val();
        $('#commentform').children('img').attr('src', "https://cdn.v2ex.com/gravatar/" + hex_md5($email) + "?s=96");
    });

//自动加入头像
function addtouxiang() {
    let $email = $('input#email');
    if($email[0] && $email.val()) $('#commentform').children('img').attr('data-src', "https://cdn.v2ex.com/gravatar/" + hex_md5($email.val()) + "?s=96");
}