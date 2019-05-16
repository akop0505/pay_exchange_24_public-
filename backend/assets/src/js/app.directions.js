(function($) {

    App.Ctrl.Directions = {};

    App.Ctrl.Directions.Grid = can.Control.extend(
        {
            pluginName: 'directions_grid'
        },
        {
            init: function () {
                this.element.ajaxLoader();

                this.form = this.element.find('form');

                this.formValuesHash = this.getFormValuesHash();

                $('input[type=text]').filter_input({regex:'[0-9,.]'});
            },

            getFormValuesHash: function () {
                var hash = '';

                $('input[type=text]').each(function (i, el) {
                    hash += $(this).val();
                });

                return md5(hash);
            },

            'input[type=text] keyup': function (el, e) {
                if (this.formValuesHash != this.getFormValuesHash()) {
                    $(window).on('beforeunload', function (e) {
                        return ' ';
                    })
                } else {
                    $(window).off('beforeunload');
                }
            },

            '.js-submit click': function (el, e) {
                $(window).off('beforeunload');
            },

            '.js-refresh click': function (el, e) {
                location.reload(true);
            },

            '.js-submit-exch-limit-min click': function (btn, e) {

                this.element.ajaxl({
                    url: btn.data('url'),
                    data: this.form.find('.js-exch-limit-input').serialize(),
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {

                }));
            },

            '.js-submit-exch-limit-max click': function (btn, e) {

                this.element.ajaxl({
                    url: btn.data('url'),
                    data: this.form.serialize(),
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {

                }));
            }
        }
    );


})(jQuery);
