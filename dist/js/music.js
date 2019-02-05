class mczoplayer {
    constructor() {
        this.dom = $('html');
        this.prev = '#player .prev';
        this.next = '#player .next';
        this.close = '#player .close';
        this.radomBTN = '#player .random';
        this.togplay = '#player .togplay';
        this.name = '#player .music-title';
        this.pic = '#player .pic';
        this.progress = '#player .playbar div';
        this.json = '//speed.mczo.net/music.json';
        this.end = 0;
        this.musiclist = null;
        this.index = 0;
        this.total = 0;
        this.list = '#musiclist li';
        this.radomTURN = 0;
        this.pausestat = 0;
        this.prevIndexValue = [];
    }

    addDOM() {
        $('<div>', {
            'id': 'player',
            html: `<div class="playbar"><div></div></div>
                   <audio id="playFrame"></audio> 
                   <div class="container" data-flex="cross-center main-between">
                        <image class="pic" />
                        <div class="music-title" data-cell></div>
                        <div class="contorl" data-flex="warp">
                            <span class="random"><svg class="icon icon-shuffle"><use xlink:href="#icon-shuffle"></use><symbol id="icon-shuffle" viewBox="0 0 24 24"><path d="M20 8c0 0.55 0.45 1 1 1s1-0.45 1-1v-5c0-0.012 0-0.025 0-0.037 0 0 0 0 0-0.006 0 0 0-0.006 0-0.006s0-0.006 0-0.006c0 0 0-0.006 0-0.006s0-0.006 0-0.006c0 0 0 0 0 0-0.006-0.106-0.031-0.206-0.069-0.3 0 0 0 0 0-0.006 0 0 0 0 0-0.006 0 0 0-0.006-0.006-0.006 0 0 0 0 0 0-0.038-0.094-0.094-0.175-0.156-0.256 0 0 0 0 0 0s-0.006-0.006-0.006-0.006c0 0 0 0 0 0s-0.006-0.006-0.006-0.006-0.006-0.006-0.006-0.006 0 0 0-0.006c-0.025-0.025-0.044-0.050-0.069-0.069 0 0 0 0-0.006 0 0 0-0.006-0.006-0.006-0.006s-0.006 0-0.006-0.006c0 0 0 0-0.006 0 0 0-0.006-0.006-0.006-0.006s0 0 0 0c-0.075-0.069-0.162-0.119-0.256-0.156 0 0 0 0 0 0s-0.006 0-0.006 0c0 0 0 0-0.006 0 0 0 0 0-0.006 0-0.094-0.038-0.194-0.063-0.3-0.069 0 0 0 0 0 0s-0.006 0-0.006 0c0 0-0.006 0-0.006 0s-0.006 0-0.006 0c0 0-0.006 0-0.006 0s0 0-0.006 0c-0.012 0-0.025 0-0.038 0h-5c-0.55 0-1 0.45-1 1s0.45 1 1 1h2.587l-15.3 15.275c-0.387 0.387-0.387 1.025 0 1.413 0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294l15.294-15.294v2.587z"></path><path d="M21.75 21.663c0 0 0-0.006 0 0 0.006-0.006 0.006-0.006 0.006-0.006s0.006-0.006 0.006-0.006c0 0 0 0 0 0s0.006-0.006 0.006-0.006c0 0 0 0 0 0 0.063-0.075 0.113-0.156 0.15-0.244 0 0 0 0 0-0.006 0 0 0-0.006 0-0.006s0-0.006 0-0.006c0 0 0 0 0 0 0.037-0.094 0.063-0.194 0.069-0.3 0 0 0 0 0 0s0-0.006 0-0.006c0 0 0-0.006 0-0.006s0-0.006 0-0.006c0 0 0-0.006 0-0.006s0 0 0-0.006c0-0.012 0-0.025 0-0.038v-5c0-0.55-0.45-1-1-1s-1 0.45-1 1v2.587l-4.45-4.475c-0.387-0.387-1.025-0.387-1.413 0s-0.387 1.025 0 1.413l4.463 4.462h-2.588c-0.55 0-1 0.45-1 1s0.45 1 1 1h5c0.006 0 0.006 0 0.012 0 0 0 0.006 0 0.006 0s0.006 0 0.006 0c0 0 0.006 0 0.006 0s0 0 0 0c0.006 0 0.006 0 0.012 0 0 0 0 0 0 0 0.125-0.006 0.244-0.031 0.35-0.081 0 0 0 0 0 0s0.006 0 0.006 0c0 0 0.006 0 0.006 0s0 0 0 0c0.075-0.031 0.144-0.075 0.213-0.131 0 0 0 0 0 0s0.006-0.006 0.006-0.006c0 0 0 0 0 0s0.006-0.006 0.006-0.006c0 0 0 0 0.006-0.006 0 0 0 0 0.006-0.006 0 0 0.006-0.006 0.006-0.006s0 0 0 0c0.031-0.025 0.056-0.050 0.081-0.081 0 0 0 0 0 0 0.012-0.006 0.019-0.012 0.019-0.012z"></path><path d="M8.463 9.875c0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294c0.387-0.387 0.387-1.025 0-1.413l-5.169-5.169c-0.387-0.387-1.025-0.387-1.413 0s-0.387 1.025 0 1.413l5.169 5.169z"></path></symbol></svg></span>
                            <span class="prev"><svg class="icon icon-skip-back"><use xlink:href="#icon-skip-back"></use><symbol id="icon-skip-back" viewBox="0 0 24 24"><path d="M20.469 3.119c-0.325-0.175-0.719-0.156-1.025 0.050l-12 8c-0.281 0.188-0.444 0.5-0.444 0.831s0.169 0.644 0.444 0.831l12 8c0.169 0.113 0.363 0.169 0.556 0.169 0.162 0 0.325-0.038 0.469-0.119 0.325-0.175 0.531-0.513 0.531-0.881v-16c0-0.369-0.2-0.706-0.531-0.881zM19 18.131l-9.2-6.131 9.2-6.131v12.263z"></path><path d="M4 3c-0.55 0-1 0.45-1 1v16c0 0.55 0.45 1 1 1s1-0.45 1-1v-16c0-0.55-0.45-1-1-1z"></path></symbol></svg></span>
                            <span class="togplay"> <svg class="icon icon-play"><use xlink:href="#icon-play"></use><symbol id="icon-play" viewBox="0 0 24 24"><path d="M19.544 11.156l-14-9c-0.306-0.2-0.7-0.213-1.019-0.037s-0.519 0.513-0.519 0.875v18c0 0.369 0.2 0.7 0.519 0.875 0.15 0.081 0.312 0.125 0.481 0.125 0.188 0 0.375-0.056 0.544-0.156l14-9c0.288-0.181 0.456-0.5 0.456-0.844s-0.181-0.65-0.462-0.837zM6 19.169v-14.337l11.15 7.169-11.15 7.169z"></path></symbol></svg> <svg class="icon icon-pause hidden"><use xlink:href="#icon-pause"></use><symbol id="icon-pause" viewBox="0 0 24 24"><path d="M9 3h-2c-1.1 0-2 0.9-2 2v14c0 1.1 0.9 2 2 2h2c1.1 0 2-0.9 2-2v-14c0-1.1-0.9-2-2-2zM9 19h-2v-14c0 0 0 0 0 0h2v14z"></path><path d="M17 3h-2c-1.1 0-2 0.9-2 2v14c0 1.1 0.9 2 2 2h2c1.1 0 2-0.9 2-2v-14c0-1.1-0.9-2-2-2zM17 19h-2v-14c0 0 0 0 0 0h2v14z"></path></symbol></svg></span>
                            <span class="next"><svg class="icon icon-skip-forward"><use xlink:href="#icon-skip-forward"></use><symbol id="icon-skip-forward" viewBox="0 0 24 24"><path d="M16.556 11.169l-12-8c-0.306-0.206-0.7-0.225-1.025-0.050-0.331 0.175-0.531 0.513-0.531 0.881v16c0 0.369 0.2 0.706 0.531 0.881 0.15 0.081 0.312 0.119 0.469 0.119 0.194 0 0.387-0.056 0.556-0.169l12-8c0.281-0.188 0.444-0.5 0.444-0.831s-0.169-0.644-0.444-0.831zM5 18.131v-12.263l9.2 6.131-9.2 6.131z"></path><path d="M20 3c-0.55 0-1 0.45-1 1v16c0 0.55 0.45 1 1 1s1-0.45 1-1v-16c0-0.55-0.45-1-1-1z"></path></symbol></svg></span>
                            <span class="close"><svg class="icon icon-x"><use xlink:href="#icon-x"></use><symbol id="icon-x" viewBox="0 0 24 24"><path d="M13.413 12l5.294-5.294c0.387-0.387 0.387-1.025 0-1.413s-1.025-0.387-1.413 0l-5.294 5.294-5.294-5.294c-0.387-0.387-1.025-0.387-1.413 0s-0.387 1.025 0 1.413l5.294 5.294-5.294 5.294c-0.387 0.387-0.387 1.025 0 1.413 0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294l5.294-5.294 5.294 5.294c0.194 0.194 0.45 0.294 0.706 0.294s0.513-0.1 0.706-0.294c0.387-0.387 0.387-1.025 0-1.413l-5.294-5.294z"></path></symbol></svg></span>
                        </div>
                   </div>`
        }).appendTo('#page');
        $('head').append('<style data-music></style>');
    }

    playToggle() {
        $(this.togplay).find('svg').toggleClass('hidden');

        if(this.musicplayer.paused) {
            this.audioPlay();

        }
        else if(this.musicplayer.played) {
            this.audioPause();
        }
    }

    addControl() {
        let _this = this;
        this.dom
            .on('click', this.radomBTN, this.radom.bind(this))
            .on('click', this.togplay, this.playToggle.bind(this))
            .on('click', this.prev, this.msprev.bind(this))
            .on('click', this.next, this.msnext.bind(this))
            .on('click', this.close, () => {
                $('#player').remove();
            })
            .on('click', '#player .playbar', this.ff.bind(this))
            .on('click', this.list, function () {
                let musicid = parseInt($(this).attr('data-musicid'));
                _this.play(musicid);
            })
            .on('keypress', (event) => {
                let e = event ? event :(window.event ? window.event : null);
                if(e.keyCode === 32) {
                    e.preventDefault();
                    this.playToggle();
                }
            });

        document.addEventListener("visibilitychange", () => {
            if(!document.hidden) {
                if(!this.pausestat) {
                    $(this.progress).removeAttr('style');
                    let width = this.musicplayer.currentTime / this.end * 100;
                    $(this.progress).width(width + '%');
                    this.barNext();
                }
            }
        });
    }

    radom() {
        if(this.radomTURN) {
            this.radomTURN = 0;
            $(this.radomBTN).removeClass('ms-focus');
            this.dom
                .off('click', this.next)
                .off('click', this.prev)
                .on('click', this.prev, this.msprev.bind(this))
                .on('click', this.next, this.msnext.bind(this));
        } else {
            this.radomTURN = 1;
            $(this.radomBTN).addClass('ms-focus');
            this.dom
                .off('click', this.next)
                .off('click', this.prev)
                .on('click', this.prev, () => {
                    this.play(this.prevIndexValue.pop());
                })
                .on('click', this.next, () => {
                    this.prevIndexValue.push(this.index);
                    this.play(parseInt(Math.random() * this.total));
                });
        }
    }

    getData() {
        $.ajaxSettings.async = false;
        $.getJSON(this.json, (data) => {
            this.musiclist = data;
            for(this.total in this.musiclist) {}
        });
        $.ajaxSettings.async = true;
    }

    start() {
        if (!$('#playFrame')[0] && $('#musiclist')[0] && !this.musiclist) {
            this.addDOM();
            this.musicplayer = document.getElementById('playFrame');
            this.addControl();
            this.getData();
            this.play();
        }
    }

    msprev() {
        this.index--;
        if(this.index < 0)
            this.index = parseInt(this.total);
        else if(!this.musiclist[this.index])
            this.index--;
        this.play();
    }

    msnext() {
        this.index++;
        if(this.index > this.total)
            this.index = 0;
        else if(!this.musiclist[this.index])
            this.index++;
        this.play();
    }

    play(index = undefined) {
        this.re();
        if(index !== undefined) this.index = index;
        this.musicplayer.src = this.musiclist[this.index].url;

        $(this.musicplayer)
            .on('loadstart', () => {
                $(this.name).text(this.musiclist[this.index].name);
                $('style[data-music]').html('li[data-musicid~="'+this.index+'"]::after{content: "";width: 2px;height: 100%;background: var(--sakura-color);position: absolute;left: 0;top: 0;}');
                $(this.pic).attr('src', this.musiclist[this.index].pic);
            })
            .on('canplay', () => {
                this.end = this.musiclist[this.index].duration / 1000;
                this.playIcon();
                this.audioPlay();
                this.barNext();
            })
            .on('error', () => {
                clearTimeout(this.errTimer);
                $(this.name).text('加载失败，准备播放下一首歌');
                this.errTimer = setTimeout(() => {
                    this.radomTURN ? this.play(parseInt(Math.random() * this.total), 1) : this.msnext();
                }, 1000)
            });

        this.nextTimer = setInterval(() => {
            if(this.musicplayer.ended) {
                this.radomTURN ? this.play(parseInt(Math.random() * this.total), 1) : this.msnext();
            }
        }, 200);
    }

    audioPlay() {
        this.musicplayer.play();
        $(this.progress).css('animation-play-state', 'running');
        this.pausestat = 0;
    }

    audioPause() {
        this.musicplayer.pause();
        $(this.progress).css('animation-play-state', 'paused');
        this.pausestat = 1;
    }

    barNext() {
        let totalTime = (this.end - this.musicplayer.currentTime)*1000;
        $(this.progress).css({
            'animation-duration' : totalTime + 'ms',
            'animation-name' : 'music-bar-end',
        });
    }

    //操作进度条
    ff(event) {
        $(this.progress).css({
            'animation-duration' : 'unset',
            'animation-name' : 'unset',
        });

        let schedule = event.pageX / $(this.progress).parent().width();

        $(this.progress).width(schedule * 100 + '%');

        setTimeout(() => {
            this.musicplayer.currentTime = this.end * schedule;
            this.musicplayer.play();
            this.playIcon();
            this.barNext();
        }, 200)
    }

    re() {
        $(this.name).text('加载中…');
        $(this.pic).removeAttr('src');
        clearInterval(this.nextTimer);
        this.pauseIcon();
        $(this.progress).removeAttr('style');
    }

    playIcon() {
        $(this.togplay).find('.icon-play').addClass('hidden');
        $(this.togplay).find('.icon-pause').removeClass('hidden');
    }

    pauseIcon() {
        $(this.togplay).find('.icon-play').removeClass('hidden');
        $(this.togplay).find('.icon-pause').addClass('hidden');
    }
}