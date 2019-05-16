(function($) {

    App.Ctrl.Accounting = {};

    App.Ctrl.Accounting.Grid = can.Control.extend(
        {
            pluginName: 'accounting_grid'
        },
        {
            init: function () {
                this.element.ajaxLoader();
            },

            '.js-remove-op-btn click': function (btn, e) {
                if (!confirm('Вы действительно хотите удалить?')) {
                    return;
                }

                this.element.ajaxl({
                    url: btn.data('url'),
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {
                    if (data.success) {
                        location.reload(true);
                    } else if (data.errors) {
                        dbg(data.errors);
                    }
                }));
            }
        }
    );


    App.Ctrl.Accounting.IncomeForm = App.Widgets.BootstrapModal.extend(
        {
            pluginName: 'accounting_IncomeForm'
        },
        {
            init: function () {
                this._super();

                this.reload = this.element.find('.modal-dialog');
                this.reload.ajaxLoader();
            },

            onShow: function () {

            },

            'form submit': function (form, e) {
                e.preventDefault();

                this.reload.ajaxl({
                    url: form.attr('action'),
                    data: form.serialize(),
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {
                    if (data.success) {
                        location.reload(true);
                    } else if (data.errors) {
                        dbg(data.errors);
                    }

                    //this.hide();
                }));
            }
        }
    );



})(jQuery);
