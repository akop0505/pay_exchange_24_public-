(function($) {

    App.Ctrl.Reserves = {};

    App.Ctrl.Reserves.Grid = can.Control.extend(
        {
            pluginName: 'reserves_grid'
        },
        {
            init: function () {
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
            }
        }
    );


})(jQuery);
