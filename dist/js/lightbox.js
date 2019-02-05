class lightbox {
    constructor(...dom) {
        this.dom = $('html');
        this.doms = dom;
        this.lightbox = '#lightbox';
        this.close = '.close';
        this.img_bg = '#lightbox .bg';
        this.nextbtn = '#lightbox .next';
        this.prevbtn = '#lightbox .prev';
        this.loading = '#lightbox .loader';
        this.title = '#lightbox .title';
        this.img = '#lightbox img';
        this.total = [];
        this.index = 0;
        this.speed = 500;
    }

    start() {
        this.fresh();
        this.event();
    }

    fresh() {
        this.total = [];
        for(let i of this.doms) {
            this.total.push(...$(i));
        }

        if(this.total[0] && !$(this.lightbox)[0]) this.inshtml();
    }

    event() {
        let _this = this;
        this.doms.map(item => {
            this.dom.on('click tap', item, function (e) {
                e.preventDefault();
                $(_this.img).remove();
                _this.index = _this.total.indexOf(this);
                _this.open();
            })
        });

        this.dom
            .on('click touchend', this.close, this.close_lightbox.bind(this))
            .on('click touchend', this.img_bg, this.close_lightbox.bind(this))
            .on('click', this.nextbtn, this.next.bind(this))
            .on('click', this.prevbtn, this.prev.bind(this))

            .on('touchstart', this.img, this.touchStart.bind(this))
            .on('touchmove', this.img, this.touchMove.bind(this))
            .on('touchend', this.img, this.touchEnd.bind(this));
    }

    touchStart(e) {
        this.beginX = this.getCursorX(e);
        this.imgWidth = $(this.img).width() / 2;
        $(this.img).css('transition', 'unset');
    }

    touchMove(e) {
        this.translateX = this.getCursorX(e) - this.beginX;
        $(this.img).css({
            'transform': 'translate3d(' + (this.translateX - this.imgWidth) + 'px, -50%, 0)'
        })
    }

    touchEnd() {
        let direction = this.getDirection(this.translateX, $(window).width() * 0.3);

        switch (direction) {
            case -1:
                this.prev();
                break;
            case 0:
                this.current();
                break;
            case 1:
                this.next();
                break;
        }
    }

    getDirection(offset, max) {
        if (offset > max) return -1;
        if (offset < -max) return 1;
        return 0;
    }

    getCursorX(e) {
        if (['mousemove', 'mousedown'].indexOf(e.type) > -1) {
            return e.pageX;
        }
        return e.changedTouches[0].pageX;
    }

    close_lightbox() {
        $(this.lightbox).removeClass('active');
    }

    inshtml() {
        let box = `
            <div id="lightbox" class="headroom-animal">
                <span class="bg"></span>
                <div class="loader"><h1>Loading…</h1><span></span><span></span><span></span></div>
                <div class="close">
                    <svg class="icon icon-x"><use xlink:href="#icon-x"></use><symbol id="icon-x" viewBox="0 0 24 24"><path d="M13.413 12l5.294-5.294c0.387-0.387 0.387-1.025 0-1.413s-1.025-0.387-1.413 0l-5.294 5.294-5.294-5.294c-0.387-0.387-1.025-0.387-1.413 0s-0.387 1.025 0 1.413l5.294 5.294-5.294 5.294c-0.387 0.387-0.387 1.025 0 1.413 0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294l5.294-5.294 5.294 5.294c0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294c0.387-0.387 0.387-1.025 0-1.413l-5.294-5.294z"></path></symbol></svg>
                </div>
                <span class="title add-border add-shadow headroom-animal"></span>
                <div class="prev">
                    <svg class="icon icon-chevron-left"><use xlink:href="#icon-chevron-left"></use><symbol id="icon-chevron-left" viewBox="0 0 24 24"><path d="M10.413 12l5.294-5.294c0.387-0.387 0.387-1.025 0-1.413s-1.025-0.387-1.413 0l-6 6c-0.387 0.387-0.387 1.025 0 1.413l6 6c0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294c0.387-0.387 0.387-1.025 0-1.413l-5.294-5.294z"></path></symbol></svg>
                </div>
                <div class="next">
                    <svg class="icon icon-chevron-right"><use xlink:href="#icon-chevron-right"></use><symbol id="icon-chevron-right" viewBox="0 0 24 24"><path d="M15.706 11.294l-6-6c-0.387-0.387-1.025-0.387-1.413 0s-0.387 1.025 0 1.413l5.294 5.294-5.294 5.294c-0.387 0.387-0.387 1.025 0 1.413 0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294l6-6c0.394-0.387 0.394-1.025 0-1.413z"></path></symbol></svg>
                </div>
            </div>`.trim();

        $('body').append(box);
    }

    open() {
        this.reset();
        let img = {
            src: $(this.total[this.index]).attr('href'),
            title: ($(this.total[this.index]).next('.wp-caption-text').text() || $(this.total[this.index]).parent('dt').next('.wp-caption-text').text()).trim(),
            dom: new Image(),
            load: function () {
                this.dom.src = this.src;
                this.dom.alt = this.title;
                this.dom.style.opacity = 0;
            }
        };
        img.load();

        if(img.title) $(this.title).text(img.title).show();

        this.timer = setInterval(() => {
            if(img.dom.complete) {
                $(this.loading).addClass('hidden');
                $(this.lightbox).append(img.dom);
                $(this.img).animate({opacity: 1});
                clearInterval(this.timer);
            }
        }, 50)
    }

    next() {
        if(this.total[this.index+1]) {
            this.index++;
            $(this.img)
                .css({
                    'transform': 'translate3d(' + -($(window).width() + $(this.img).width()/2) + 'px, -50%, 0)',
                    'transition': 'all ' + this.speed + 'ms',
                    'z-index': 3,
                });
            setTimeout(() => {
                if($(this.img)[0]) $(this.img)[0].remove();
            }, this.speed);
            this.open();
        } else {
            this.current(this.speed);
        }
    }
    
    prev() {
        if(this.index) {
            this.index--;
            $(this.img)
                .css({
                    'transform': 'translate3d(' + $(window).width() + 'px, -50%, 0)',
                    'transition': 'all ' + this.speed + 'ms',
                    'z-index': 3,
                });
            setTimeout(() => {
                if($(this.img)[0]) $(this.img)[0].remove();
            }, this.speed);
            this.open();
        } else {
            this.current(this.speed);
        }
    }

    current() {
        $(this.img)
            .css({
                'transform': 'translate3d(-50%, -50%, 0)',
                'transition': 'all ' + this.speed + 'ms',
            });
    }

    reset() {
        $(this.nextbtn).removeClass('hidden');
        $(this.prevbtn).removeClass('hidden');
        $(this.lightbox).addClass('active');
        $(this.loading).removeClass('hidden');
        $(this.title).hide();
        clearInterval(this.timer);
        if(this.index+1 === this.total.length) $(this.nextbtn).addClass('hidden');
        if (!this.index) $(this.prevbtn).addClass('hidden');
    }
}