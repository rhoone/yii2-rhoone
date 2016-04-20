/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.name/
 * @copyright Copyright (c) 2016 vistart
 * @license https://vistart.name/license/
 */

rhoone.search = (function ($) {
    var pub = {
        count: 0,
        keywords: "",
        start: function () {
            $(document).trigger("rhoone:search_start");
        },
        cancel: function () {
            $(document).trigger("rhoone:search_cancel");
        },
        end: function () {
            $(document).trigger("rhoone:search_end");
        },
        init: function () {
        },
    };
    return pub;
})(jQuery);