(function($){

    /**
     * jQuery ajax with view loader on process
     * @param opts
     * @returns {$.ajax}
     */
    $.fn.ajaxl = function(opts) {

        let el = $(this),
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

    App.Ctrl.AjaxLoader = can.Control.extend(
        {
            pluginName: 'ajaxLoader',
            defaults: {
                loader: '<img class="form-loader__image" src="/images/loader.svg" />',
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