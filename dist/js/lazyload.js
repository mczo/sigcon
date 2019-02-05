class LazyLoad {
    constructor() {
        this.images = [];
        this.timeout = null;
        this.startTime = new Date();
    }

    fresh() {
        this.images = [...document.querySelectorAll('img[data-src]')];
        LazyLoad.that = this;

        this.scroll();

        this.remove_action();
        this.add_action();
    }

    add_action() {
        window.addEventListener("scroll", this.lazy_scroll);
    }

    remove_action() {
        window.removeEventListener("scroll", this.lazy_scroll);
    }

    lazy_scroll() {
        let that = LazyLoad.that;
        let curTime = new Date();
        clearTimeout(that.timeout);
        if (curTime - that.startTime >= 1000) {
            that.scroll();
            that.startTime = curTime;
        } else {
            that.timeout = setTimeout (that.scroll, 500);
        }
    }

    scroll() {
        if(LazyLoad.that.images[0]) {
            let scrTop = LazyLoad.getSrcTop();
            let showed = [];
            for (let img of LazyLoad.that.images) {
                let a = LazyLoad.getOffsetTop(img);
                if (a < scrTop + LazyLoad.getCliHeight()) {
                    let data_src = img.dataset.src;
                    showed.push(img);
                    if (data_src && img.src !== data_src) {
                        LazyLoad.loadImageAsync(data_src).then((url) => {
                            img.src = url;
                            // console.log('load')
                        });
                    }
                }
            }
            showed.forEach(item1 => {
                LazyLoad.that.images.forEach((item2, index) => {
                    if(item1 === item2) {
                        LazyLoad.that.images.splice(index, 1);
                    }
                })
            })
            // console.log(LazyLoad.that.images)
        } else {
            LazyLoad.that.remove_action();
        }
    }

    static loadImageAsync(url) {
        return new Promise((resolve, reject) => {
            const image = new Image();

            image.onload = function() {
                resolve(url);
            };

            image.onerror = function() {
                reject();
            };

            image.src = url;
        })
    }

    static getSrcTop() {
        return document.documentElement.scrollTop || document.body.scrollTop;
    }

    static getCliHeight() {
        return document.documentElement.clientHeight;
    }

    static getOffsetTop(node) {
        return node.getBoundingClientRect().top + LazyLoad.getSrcTop();
    }
}