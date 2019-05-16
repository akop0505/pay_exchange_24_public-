(function($) {

    App.Ctrl.Autobalance = {};

    App.Ctrl.Autobalance.Grid = can.Control.extend(
        {
            pluginName: 'autobalance_grid'
        },
        {
            init: function () {

                this.refreshBtn = this.element.find('.js-refresh');

                //this.refresh();
                //setInterval(this.proxy(this.refresh), 15000);

                this.fAjaxUpdate = true;

                this.autobalancing = false;
                setInterval(this.proxy(this.ajaxUpdate), 1000);
            },

            refresh: function () {

                this.refreshBtn.button('loading');

                $.ajax({
                    url: this.element.data('refresh-url'),
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {

                    var grid = this.element.find('table');

                    for (var id in data) {
                        var row = grid.find('[data-direction-id=' + id + ']');

                        row.find('.js-total-positions').text(data[id].totalPositions);
                        row.find('.js-current-position').text(data[id].currentPosition);
                        row.find('.js-current-position').addClass(data[id].currentPositionStatus);
                        row.find('.js-monitor-course').html(data[id].courseStr);
                    }

                })).always(this.proxy(function () {

                    this.refreshBtn.button('reset');

                }));
            },

            '.js-refresh click': function (btn, e) {
                e.preventDefault();

                this.refresh();
            },

            '.js-enable-btn change': function (el, e) {

                if (el.is(':checked')) {
                    $.ajax({
                        url: this.element.data('enable-url'),
                        data: {enable: el.val()},
                        dataType: 'JSON'
                    });
                }
            },

            '.js-enable-ab-btn change': function (el, e) {
                this.fAjaxUpdate = el.is('.js-enable-ajax');
            },

            ajaxUpdate: function () {
                if (!this.fAjaxUpdate || this.autobalancing) {
                    return;
                }
                this.autobalancing = true;

                $.ajax({
                    url: this.element.data('ajax-url'),
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {
                    this.refresh();
                })).always(this.proxy(function (data) {
                    this.autobalancing = false;
                }));
            }
        }
    );

    App.Ctrl.Autobalance.EditField = can.Control.extend(
        {
            pluginName: 'autobalance_editField'
        },
        {
            init: function () {

                this.attribute = this.element.data('attribute');

                this.viewAria = this.options.viewAria = this.element.find('.js-view-aria');
                this.editAria = this.options.editAria = this.element.find('.js-edit-aria');
                this.editInput = this.options.editInput = this.element.find('.js-edit-input');

                this.on();

                this.editInput.filter_input({regex:'[0-9,.]'});

                this.saveProcess = false;
            },

            save: function () {

                if (this.saveProcess) {
                    return;
                }

                this.saveProcess = true;

                $.ajax({
                    url: this.element.data('url'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: this.element.find(':input').serialize()
                }).done(this.proxy(function (data) {

                    this.viewAria.text(data.model[this.attribute]);
                    this.hideEdit();

                    if (data.updateImmediate) {
                        App.CtrlInstances.autobalance_grid.refresh();
                    }

                })).always(this.proxy(function () {

                    setTimeout(this.proxy(function () {
                        this.saveProcess = false;
                    }), 500);

                }));
            },

            showEdit: function () {
                this.viewAria.hide();
                this.editAria.show();
                this.editInput.trigger('focus');
            },

            hideEdit: function () {
                this.editAria.hide();
                this.viewAria.show();
            },

            '{viewAria} click': function (el, e) {
                this.showEdit();
            },

            '{editInput} keyup': function (el, e) {
                if (e.keyCode == 13) {
                    this.save();
                }
            },

            '{editInput} focusout': function (el, e) {
                this.save();
            }
        }
    );


})(jQuery);
