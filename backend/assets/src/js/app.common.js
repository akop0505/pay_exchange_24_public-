(function($){


    window.getURLParam = function (name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    /**
     * jQuery ajax with view loader on process
     * @param opts
     * @returns {$.ajax}
     */
    $.fn.ajaxl = function(opts){
        var el = $(this),
            before = opts.beforeSend || function(){},
            complete = opts.complete || function(){};

        opts.beforeSend = function(){
            el.trigger('loader.begin');
            before.apply($.ajax, arguments);
        };

        opts.complete = function(){
            complete.apply($.ajax, arguments);
            el.trigger('loader.end');
        };

        return $.ajax.apply($.ajax, [opts]);
    };

    var currentModal = null;

    App.Widgets.BootstrapModal = can.Control.extend(
        {
            pluginName: 'appWidgetsBootstrapModal',
            defaults: {
                caller: null
            },
            listensTo: ['show.bs.modal', 'hide.bs.modal', 'update.callers']
        },
        {
            init: function () {
                this.options.callerElement  = $(this.options.caller);
                this.caller = null;
                this.opened = false;
                this.on();

                if (this.element.data('show-now')) {
                    this.show();
                }

                $('body').on('click', this.options.caller, this.proxy(this.onCallerClick))
            },

            onCallerClick: function (e) {
                e.preventDefault();

                this.caller = $(e.currentTarget);
                this.show();
            },

            onShow: function () {

            },

            onHide: function () {

            },

            show: function () {
                this.element.modal('show');
            },

            hide: function () {
                this.element.modal('hide');
            },

            'show.bs.modal': function (m, e) {
                if (currentModal) {
                    currentModal.modal('hide');
                }
                currentModal = this.element;
                this.opened = true;
                this.onShow();

                setTimeout(function () {
                    $('body').addClass('modal-open');
                }, 500);
            },

            'hide.bs.modal': function () {
                currentModal = null;
                this.caller = null;
                this.opened = false;
                this.onHide();
            }
        }
    );

    App.Ctrl.AjaxLoader = can.Control.extend(
        {
            pluginName: 'ajaxLoader',
            defaults: {
                loader: '<img class="form-loader__image" src="/manage/images/loader.svg" />',
                loaderClass: 'ajax-loader',
                wrapperClass: 'form-loader'
            },
            listensTo: ['loader.begin', 'loader.end']
        },
        {
            init: function(){
                this.o = this.options;

                this.el = this.element;
                this.loader = $(this.o.loader);
                this.loader.addClass(this.o.loaderClass);

                this.wrapper = $('<div class="'+this.o.wrapperClass+'" />').append(this.loader);

                this.wrapper
                    .css({position: 'absolute', 'z-index': 299, top: 0, left: 0, bottom: 0, right: 0, display: 'none', background: 'rgba(255,255,255,0.5)'})
                    .appendTo(this.el);
            },

            'loader.begin': function(el, e){
                e.stopImmediatePropagation();
                this.wrapper.show();
            },

            'loader.end': function(el, e){
                e.stopImmediatePropagation();
                this.wrapper.hide();
            }
        }
    );
}(jQuery));