(function($) {

    App.Ctrl.Referrals = {};

    App.Ctrl.Referrals.Filter = can.Control.extend(
        {
            pluginName: 'referrals_filter'
        },
        {
            init: function () {
                this.form = this.element.find('form');
                this.select = this.element.find('.js-monitor');
                this.select.select2();
            },

            '.js-monitor change': function (el, e) {
                this.submit_filter();
            },

            submit_filter: function () {
                var val = this.select.val();

                window.location = val > 0 ? this.element.data('url') + '/' + val : this.element.data('back-url');
            }
        }
    );

    App.Ctrl.Referrals.WithdrawForm = can.Control.extend(
        {
            pluginName: 'referrals_withdraw_form'
        },
        {
            init: function () {
                this.element.ajaxLoader();

                this.form = this.element.find('form');
            },

            'form submit': function (form, e) {
                e.preventDefault();

                this.element.ajaxl({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: form.serialize()
                }).done(this.proxy(function (data) {
                    if (data.success) {
                        App.CtrlInstances.referrals_filter.submit_filter();
                    }
                }));
            }
        }
    );

    can.Control.extend(
        {
            pluginName: 'referrals_correct_form'
        },
        {
            init: function () {
                this.element.ajaxLoader();

                this.form = this.element.find('form');
            },

            'form submit': function (form, e) {
                e.preventDefault();

                this.element.ajaxl({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: form.serialize()
                }).done(this.proxy(function (data) {
                    if (data.success) {
                        App.CtrlInstances.referrals_filter.submit_filter();
                    }
                }));
            }
        }
    );

    can.Control.extend(
        {
            pluginName: 'referrals_percent_form'
        },
        {
            init: function () {
                this.element.ajaxLoader();

                this.form = this.element.find('form');
            },

            'form submit': function (form, e) {
                e.preventDefault();

                this.element.ajaxl({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: form.serialize()
                }).done(this.proxy(function (data) {
                    if (data.success) {
                        App.CtrlInstances.referrals_filter.submit_filter();
                    }
                }));
            }
        }
    );

})(jQuery);
