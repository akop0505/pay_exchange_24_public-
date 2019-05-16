(function($) {

    App.Ctrl.Config = {};

    App.Ctrl.Config.Works = can.Control.extend(
        {
            pluginName: 'config_works'
        },
        {
            init: function () {

            },

            '.js-enable-btn change': function (el, e) {

                if (el.is(':checked')) {
                    $.ajax({
                        url: this.element.data('enable-url'),
                        data: {enable: el.val()},
                        dataType: 'JSON'
                    });
                }

            }
        }
    );


    App.Ctrl.Config.NY = can.Control.extend(
        {
            pluginName: 'config_new_year'
        },
        {
            init: function () {
                this.isEnable = this.element.find('input:checked').val();

                this.oInput = $('#settings-text_tech_works');
                this.oBtn = $('#w0 button');
                this.oLabels = $('.config_works label');

                this.triggerEnable(this.isEnable);
            },

            triggerEnable: function (isEnable) {
                if (isEnable > 0) {
                    this.oInput.attr('disabled', 'disabled');
                    this.oBtn.addClass('disabled').attr('disabled', 'disabled');
                    this.oLabels.addClass('disabled');
                } else {
                    this.oInput.removeAttr('disabled');
                    this.oBtn.removeClass('disabled').removeAttr('disabled');
                    this.oLabels.removeClass('disabled');
                }
            },

            '.js-enable-btn change': function (el, e) {

                if (el.is(':checked')) {
                    $.ajax({
                        url: this.element.data('enable-url'),
                        data: {enable: el.val()},
                        dataType: 'JSON'
                    }).done(this.proxy(function (data) {
                        this.triggerEnable(data.enable);
                    }));
                }

            }
        }
    );


})(jQuery);
