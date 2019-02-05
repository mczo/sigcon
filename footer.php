                </div><!--#var-box-->
            </div>

            <footer id="page-foot" class="text-center" data-flex="main-center cross-center col">
                <span>
                    <span><a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo get_option( 'zh_cn_l10n_icp_num' ); ?></a></span><?php if(get_option('mczo_gonganbeian_setting')): ?><span><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo preg_replace('/\D/s', '', get_option('mczo_gonganbeian_setting')); ?>" target="_blank"><?php echo get_option('mczo_gonganbeian_setting'); ?></a></span><?php endif ?>
                </span>
                <span>
                    <span>© <?php echo date("Y")?> <?php bloginfo('name'); ?></span><span>Powered by <a href="https://cn.wordpress.org" target="_blank">WordPress</a></span>
                </span>
            </footer>
        </div><!--#content-->

        <div id="goto-top">
            <svg class="icon icon-chevron-up">
                <use xlink:href="#icon-chevron-up"></use>
                <symbol id="icon-chevron-up" viewBox="0 0 20 20">
                    <title>chevron-up</title>
                    <path d="M15.484 12.452c-0.436 0.446-1.043 0.481-1.576 0l-3.908-3.747-3.908 3.747c-0.533 0.481-1.141 0.446-1.574 0-0.436-0.445-0.408-1.197 0-1.615 0.406-0.418 4.695-4.502 4.695-4.502 0.217-0.223 0.502-0.335 0.787-0.335s0.57 0.112 0.789 0.335c0 0 4.287 4.084 4.695 4.502s0.436 1.17 0 1.615z"></path>
                </symbol>
            </svg>
        </div>
    </div><!--#page-->
    <?php wp_footer(); ?>
    <script type="text/javascript">LazyLoadZiyuan=(function(doc){var env,head,pending={},pollCount=0,queue={css:[],js:[]},styleSheets=doc.styleSheets;function createNode(name,attrs){var node=doc.createElement(name),attr;for(attr in attrs){if(attrs.hasOwnProperty(attr)){node.setAttribute(attr,attrs[attr])}}return node}function finish(type){var p=pending[type],callback,urls;if(p){callback=p.callback;urls=p.urls;urls.shift();pollCount=0;if(!urls.length){callback&&callback.call(p.context,p.obj);pending[type]=null;queue[type].length&&load(type)}}}function getEnv(){var ua=navigator.userAgent;env={async:doc.createElement("script").async===true};(env.webkit=/AppleWebKit\//.test(ua))||(env.ie=/MSIE|Trident/.test(ua))||(env.opera=/Opera/.test(ua))||(env.gecko=/Gecko\//.test(ua))||(env.unknown=true)}function load(type,urls,callback,obj,context){var _finish=function(){finish(type)},isCSS=type==="css",nodes=[],i,len,node,p,pendingUrls,url;env||getEnv();if(urls){urls=typeof urls==="string"?[urls]:urls.concat();if(isCSS||env.async||env.gecko||env.opera){queue[type].push({urls:urls,callback:callback,obj:obj,context:context})}else{for(i=0,len=urls.length;i<len;++i){queue[type].push({urls:[urls[i]],callback:i===len-1?callback:null,obj:obj,context:context})}}}if(pending[type]||!(p=pending[type]=queue[type].shift())){return}head||(head=doc.head||doc.getElementsByTagName("head")[0]);pendingUrls=p.urls.concat();for(i=0,len=pendingUrls.length;i<len;++i){url=pendingUrls[i];if(isCSS){node=env.gecko?createNode("style"):createNode("link",{href:url,rel:"stylesheet"})}else{node=createNode("script",{src:url});node.async=false}node.className="lazyload";node.setAttribute("charset","utf-8");if(env.ie&&!isCSS&&"onreadystatechange" in node&&!("draggable" in node)){node.onreadystatechange=function(){if(/loaded|complete/.test(node.readyState)){node.onreadystatechange=null;_finish()}}}else{if(isCSS&&(env.gecko||env.webkit)){if(env.webkit){p.urls[i]=node.href;pollWebKit()}else{node.innerHTML='@import "'+url+'";';pollGecko(node)}}else{node.onload=node.onerror=_finish}}nodes.push(node)}for(i=0,len=nodes.length;i<len;++i){head.appendChild(nodes[i])}}function pollGecko(node){var hasRules;try{hasRules=!!node.sheet.cssRules}catch(ex){pollCount+=1;if(pollCount<200){setTimeout(function(){pollGecko(node)},50)}else{hasRules&&finish("css")}return}finish("css")}function pollWebKit(){var css=pending.css,i;if(css){i=styleSheets.length;while(--i>=0){if(styleSheets[i].href===css.urls[0]){finish("css");break}}pollCount+=1;if(css){if(pollCount<200){setTimeout(pollWebKit,50)}else{finish("css")}}}}return{css:function(urls,callback,obj,context){load("css",urls,callback,obj,context)},js:function(urls,callback,obj,context){load("js",urls,callback,obj,context)}}})(this.document);window.onload=function(){LazyLoadZiyuan.css(mczo_other_info.css_url,function(){LazyLoadZiyuan.js(mczo_other_info.js_url);document.getElementById("open-loading").className="hides"})};mczo_other_info={"ajax_url":"/wp-admin/admin-ajax.php","css_url":"/wp-content/themes/sigcon/dist/css/css.php?ver=403","js_url":"/wp-content/themes/sigcon/dist/js/js.php?ver=403"};</script>
</body>
</html>