(function($) {

    App.Ctrl.Stats = {};

    App.Ctrl.Stats.Filter = can.Control.extend(
        {
            pluginName: 'stats_Filter'
        },
        {
            init: function () {

            },

            '.js-filter-btn label click': function (el, e) {
                $('.js-date').val('');
            }
        }
    );


})(jQuery);
