/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.name/
 * @copyright Copyright (c) 2016 vistart
 * @license https://vistart.name/license/
 */

rhoone = (function ($) {
    var pub = {
        search_box_selector: "#search",
        search_result_selector: "#result",
        search_url: '/search',
        search_counter: 0,
        search_timeout: 1000, // in millisecond.
        search_timeout_callback: null,
        search_start_handler: null,
        search_done_handler: null,
        alert: function (content) {
            window.alert(content);
        },
        search_box_changed: function (counter)
        {
            this.search_counter = counter;
            if (this.search_timeout_callback) {
                clearTimeout(this.search_timeout_callback);
            }
            this.search_timeout_callback = setTimeout("rhoone.search_delay()", 500);
        },
        search_delay: function ()
        {
            if (this.search_counter < this.search_timeout) {
                this.search_counter += 500;
                //console.log(pub.search_counter);
                this.search_timeout_callback = setTimeout("rhoone.search_delay()", 500);
            } else {
                this.search_counter = 0;
                clearTimeout(this.search_timeout_callback);
                value = $(this.search_box_selector).val();
                if (value.length > 0) {
                    this.post_keywords(value);
                }
            }
            $(this.search_box_selector).focus();
        },
        post_keywords: function (keywords) {
            if ($.isFunction(this.search_start_handler)) {
                this.search_start_handler();
            }
            this.post(this.search_url, {keywords: keywords}, this.search_done_handler);
        },
        run: function () {
            $(this.search_box_selector).focus();
            $(this.search_box_selector).bind("input", function (e) {
                //console.log($(e.currentTarget).val());
                rhoone.search_box_changed(0);
            });
            $(this.search_box_selector).bind("propertychanged", function (e) {
                //console.log($(e.currentTarget).val());
                rhoone.search_box_changed(0);
            });
        },
        /**
         * 
         * @param string url
         * @param array parameters
         * @param callback successCallback
         * @param callback failCallback
         * @param callback postFailCallback
         * @param callback postAlwaysCallback
         * @returns mixed, determined by callback.
         */
        post: function (url, parameters, successCallback, failCallback, postFailCallback, postAlwaysCallback) {
            var posting = $.post(url, parameters, function (data, status) {
                if (status !== "success" || !data.success) {
                    if (!$.isFunction(failCallback) && $.isFunction(successCallback)) {
                        return successCallback(data, status);
                    }
                    if ($.isFunction(failCallback)) {
                        return failCallback(data.data, status);
                    }
                }
                if ($.isFunction(successCallback)) {
                    return successCallback(data.data, status);
                }
            });
            if ($.isFunction(postFailCallback)) {
                posting.fail(postFailCallback);
            }
            if ($.isFunction(postAlwaysCallback)) {
                posting.always(postAlwaysCallback);
            }
            return posting;
        },
        /**
         * Load parameter from variable defined in anyother place. You should
         * ensure the external variable defined, otherwise it will not work.
         * @param {variable} external External variable to be loaded. If this
         * variable is undefined, the internal will not be affected.
         * @param {variable} internal Property or internal variable should be set.
         * @param {string|undefined} type
         * @returns {undefined} this method will not return anything.
         */
        loadExternalParameter: function (external, internal, type) {
            if (external !== undefined) {
                if (type === undefined || typeof type !== "string") {
                    type = "string";
                }
                if (typeof external === type) {
                    internal = external;
                }
            }
        },
        initModule: function (module) {
            if (module.isActive === undefined || module.isActive) {
                if ($.isFunction(module.init)) {
                    module.init();
                }
                $.each(module, function () {
                    if ($.isPlainObject(this)) {
                        pub.initModule(this);
                    }
                });
            }
        }
    };
    return pub;
})(jQuery);

jQuery(document).ready(function () {
    rhoone.initModule(rhoone);
});