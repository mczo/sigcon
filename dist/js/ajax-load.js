let [topmain, navbar_li, $ajx_main] = [
    $("body"),
    $("#navbar-list").find("li"),
    $("#var-box"),
];
let ajx_main = '#var-box' , // 要替换的主体id，改为你文章部分的容器
    ajx_a = 'a[target!=_blank]' , // a标签，自己添加排除规则
    ajx_replyform = '#comment-list #commentform',
    ajx_comment_input = 'textarea#comment',
    ajx_comtlist = '#comment-list' , // 评论列表id或class
    ajx_comtbtnbox = '#comments-load-more',
    ajx_sform = 'form.search-form' , // 搜索表单form标签
    ajx_skey = '.search-field' , // 搜索表单input标签内的id或class
    ajx_respond = '#respond',
    ajx_inxcontent = '#list-continue' ,
    ajx_inxbtnbox = '.navigation.pagination';
let mczo_scroll = {
        dom: "body, html",
        speed: 300,
        top: function (animal = true) {
            let speed = animal ? this.speed : 0;
            $(this.dom).stop().animate({scrollTop: 0}, speed);
        },
        mao: function (id, animal = true) {
            let speed = animal ? this.speed : 0;
            $(this.dom).stop().animate({scrollTop: $(id).offset().top}, speed);
        }
    };

function reload_func(){
    mczolightbox.fresh();
    mczoplayer.start();
    mczoLoadInFun();
    lazyLoad.fresh();
}

function mczo_ajx_show() {
    setTimeout(() => {
        $('.list-fade-out').removeClass('list-fade-out');
    }, 100);
}

$(function() {
    a(); //pushState初始化执行一次
});
// 函数：更新浏览器历史缓存（用于浏览器后退）
function l(){
    history.replaceState( // 刷新历史点保存的数据，给state填入正确的内容
        {    url: window.document.location.href,
            title: window.document.title,
            html: $(document).find(ajx_main).html() // 抓取主体部分outerHTML用于呈现新的主体。也可以用这句 html: $(ajx_main).prop('outerHTML'),
        }, window.document.title, document.location.href);
}
// 函数：页面载入初始一次，解决Chrome浏览器初始载入时产生ajax效果的问题,并且监听前进后退事件
function a(){
    window.addEventListener( 'popstate', function( e ){  //监听浏览器后退事件
        if( e.state ){
            document.title = e.state.title;
            $(ajx_main).html( e.state.html ); //也可以用replaceWith ，最后这个html就是上面替换State后里面的html值
            // 重载js
            window.load =  reload_func(); // 重载函数
        }
    });
}
//函数：AJAX核心
function ajax(reqUrl, msg, method, data) {
    switch (msg) {
        case 'pagelink':
            navbar_li.removeClass('current-menu-item');  //删除焦点菜单
            $ajx_main.addClass('loading');
            break;
        case 'search':
            navbar_li.removeClass('current-menu-item');  //删除焦点菜单
            $ajx_main.addClass('loading');
            mczo_scroll.top(false);
            break;
        case 'comment':
            $(ajx_comment_input)
                .val('')
                .attr('placeholder', '评论发射中……');
            break;
        case 'commentReply':
            $(ajx_comment_input)
                .val('')
                .attr('placeholder', '评论发射中……');
            break;
        case 'loadcomment':
            $(ajx_comtbtnbox).html(`<span class="ajx-load-more">加载中…</span>`);
            break;
        case 'indexNav':
            $(ajx_inxbtnbox).html(`<span class="ajx-load-more">加载中…</span>`);
            break;
    }

    $.ajax({
        url: reqUrl,
        type: method,
        data: data,
        beforeSend : function () { //加载前操作 这个必须放在window.history.pushState()之前，否则会出现逻辑错误。
            l(); //刷新历史点内容，这个必须放在window.history.pushState()之前，否则会出现逻辑错误。
        },
        success: function(data) {
            switch (msg) {
                case 'pagelink': // 又如果msg为 页面 或 搜索—— 【1】
                    $(ajx_main).html($(data).find(ajx_main).html()) ; // 替换原#main的内容
                    $ajx_main.removeClass('loading');
                    change_urland_tittle();
                    break;
                case 'search': // 又如果msg为 页面 或 搜索—— 【1】
                    $(ajx_main).html($(data).find(ajx_main).html()) ; // 替换原#main的内容
                    $ajx_main.removeClass('loading');
                    change_urland_tittle();
                    break;
                case 'comment': // 又如果msg为 评论回复——————————【2】
                    if($(ajx_comtlist)[0]) {
                        $(ajx_comtlist).prepend($(data).find(ajx_comtlist + ' > li:first-child').addClass('list-fade-out'));//  评论列表滑出
                        mczo_ajx_show();
                    }
                    else
                        $(ajx_respond).after($(data).find(ajx_comtlist));
                    break;
                case 'commentReply':
                    let commentID = '#' + $(ajx_respond).parent().attr('id');
                    if(!$(commentID).children('ul.children')[0])
                        $(commentID).children('.comment-body').after($(data).find(commentID).children('ul.children'));
                    else {
                        $(commentID).children('ul.children').append($(data).find(commentID).children('ul.children').children('li:last-child').addClass('list-fade-out'));
                        mczo_ajx_show();
                    }
                    break;
                case 'loadcomment':
                    $(ajx_comtbtnbox).remove();
                    $ajx_main.append($(data).addClass('list-fade-out'));
                    mczo_ajx_show();
                    addtouxiang();
                    break;
                case 'indexNav':
                    $(ajx_inxbtnbox).remove();
                    $(ajx_inxcontent).append($(data).find(ajx_inxcontent).children().addClass('list-fade-out'));
                    mczo_ajx_show();
                    if($(ajx_inxbtnbox).find('.next').length === 0){
                        $(ajx_inxbtnbox).html('已经没有内容可以加载了');
                    }
                    break;
            }

            function change_urland_tittle() {
                document.title = $(data).filter("title").text(); // 浏览器标题变更
                let state = { // 设置state参数
                    url: reqUrl,
                    title: $(data).filter("title").text(),
                    html: $(data).find(ajx_main).html()
                };
                // 将当前url和历史url添加到浏览器当中，用于后退。里面三个值分别是: state, title, url
                window.history.pushState(state, $(data).filter("title").text(), reqUrl);
            }
        },
        complete: function() { // ajax完成后加载
            switch (msg) {
                case 'pagelink':
                    window.location.hash.indexOf('#') !== -1 ? mczo_scroll.mao(window.location.hash, false) : mczo_scroll.top(false);
                    navbar_li.each(function () {
                        if(reqUrl === $(this).find('a').attr('href')) $(this).addClass('current-menu-item');
                    });        //添加焦点菜单
                    break;
                case 'comment':
                    $(ajx_comment_input).attr('placeholder', '发射成功 o(^▽^)o');
                    setTimeout(() => {
                        $(ajx_comment_input).attr('placeholder', '说些感想吧……');
                    }, 2000);
                    break;
                case 'commentReply':
                    $(ajx_comment_input).attr('placeholder', '发射成功 o(^▽^)o');
                    setTimeout(() => {
                        $(ajx_comment_input).attr('placeholder', '说些感想吧……');
                    }, 2000);
                    break;
            }
            window.load =  reload_func(); // 重载函数
        },
        timeout: 5000, // 超时长度
        error: function(request) { // 错误时的处理
            switch (msg) {
                case 'pagelink':
                    location.href = reqUrl;
                    break;
                case 'search':
                    location.href = reqUrl;
                    break;
                case 'comment':
                    alert($(request.responseText).filter("p").text()); // 弹出警告,这个是必需的，如果删除那么提交错误时就会打开空白页面
                    $(ajx_comment_input).attr('placeholder', '说些感想吧……');
                    break;
                case 'commentReply':
                    alert($(request.responseText).filter("p").text()); // 弹出警告,这个是必需的，如果删除那么提交错误时就会打开空白页面
                    $(ajx_comment_input).attr('placeholder', '说些感想吧……');
                    break;
                case 'loadcomment':
                    $(ajx_comtbtnbox).html('抱歉，加载失败了:(');
                    break;
                case 'indexNav':
                    $(ajx_inxbtnbox).html('抱歉，加载失败了:(');
                    break;
                default:
                    location.href = reqUrl;
            }
        }
    });
}
//页面ajax
topmain
    .on("click",ajx_a,
        function(e) {
            if(!$(this).hasClass('page-numbers') && $(this).attr('data-rel') !== 'lightbox' && this.id !== 'cancel-comment-reply-link' && !$(this).hasClass('comment-reply-link'))
                ajax($(this).attr("href"), 'pagelink');
            e.preventDefault();
        })
    //评论ajax
    .on('submit','#comments > #respond #commentform',
        function(e) {
            ajax(mczo_other_info.ajax_url, 'comment', $(this).attr('method'), $(this).serialize() + "&action=ajax_comment");
            e.preventDefault();
        })
    //回复评论ajax
    .on('submit',ajx_replyform,
        function(e) {
            ajax(mczo_other_info.ajax_url, 'commentReply', $(this).attr('method'), $(this).serialize() + "&action=ajax_comment");
            e.preventDefault();
        })
    //搜索ajax
    .on('submit',ajx_sform,
        function(e) {
            ajax(this.action + '?s=' + $(this).find(ajx_skey).val(), 'search');
            e.preventDefault();
        });

//滚动加载分页
function mczoLoadInFun () {
    let commentIndex = $(ajx_comtbtnbox + " .text"),
        pageIndex = $(ajx_inxbtnbox + " .next");
    if(commentIndex[0]) {
        let a = commentIndex.offset().top;
        if(a >= $(window).scrollTop() && a < ($(window).scrollTop() + $(window).height()))
            ajax(mczo_other_info.ajax_url, 'loadcomment', 'POST', {'action':'load_comment', 'post_id': $(ajx_comtbtnbox).attr('data-postid')});
    } else if(pageIndex[0]) {
        let a = pageIndex.offset().top;
        if(a >= $(window).scrollTop() && a < ($(window).scrollTop() + $(window).height()))
            ajax(pageIndex.attr("href"), 'indexNav');
    }
}

function mczoLazyScroll(fn, total, delay) {
    let timeout = null;
    let startTime = new Date();
    return () => {
        let curTime = new Date();
        clearTimeout(timeout);
        if(curTime - startTime >= total) {
            fn();
            startTime = curTime;
        } else {
            timeout = setTimeout(fn, delay);
        }
    }
}

window.addEventListener("scroll", mczoLazyScroll(mczoLoadInFun, 1000, 500));

