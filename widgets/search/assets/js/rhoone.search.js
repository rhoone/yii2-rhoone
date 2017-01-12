/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2017 vistart
 * @license https://vistart.me/license/
 */

rhoone.search = (function ($) {
    var pub = {
        oldKeywords: null,
        keywords: "",
        delay_callback: null,
        start: function (reload) {
            if (typeof reload === "undefined") {
                reload = false;
            }
            if (reload || ((typeof this.keywords).toLowerCase() === "string" && this.keywords.length > 0 && this.keywords !== this.oldKeywords)) {
                this.oldKeywords = this.keywords;
                $(document).trigger("rhoone:search_start");
            }
        },
        cancel: function () {
            $(document).trigger("rhoone:search_cancel");
        },
        end: function () {
            $(document).trigger("rhoone:search_end");
        },
        delay_start: function (duration, interval) {
            if (typeof duration === "undefined") {
                duration = 1000;
            }
            if (typeof interval === "undefined") {
                interval = 100;
            }
            //console.log(duration);
            if (this.delay_callback) {
                clearTimeout(this.delay_callback);
                this.delay_callback = null;
            }
            if (duration <= 0) {
                duration = 0;
                this.start();
                return;
            }
            this.delay_callback = setTimeout("rhoone.search.delay_start(" + (duration - interval) + ", " + interval + ")", interval);
        },
    };
    return pub;
})(jQuery);