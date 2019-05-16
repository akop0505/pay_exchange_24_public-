(function($) {

    App.Ctrl.Lk = {};


    App.Ctrl.Lk.FeedbackForm = can.Control.extend(
        {
            pluginName: 'feedback_form'
        },
        {
            init: function(){
                this.el = this.element;
                this.form = this.el.find('form');
                this.error = this.el.find('.js-error');

                $('.js-feedback-form-open').on('click', (e) => {
                    e.preventDefault();

                    this.form.trigger('reset');
                    this.error.hide();
                    grecaptcha.reset();
                    this.el.modal('open');
                });

                this.form.ajaxLoader();
            },

            'form submit': function(form, e){
                e.preventDefault();

                this.error.text('');
                form.removeClass('error');

                form.ajaxl({
                    url: form.attr('action'),
                    data: form.serialize(),
                    type: 'POST',
                    dataType: 'JSON'
                }).done((data) => {

                    grecaptcha.reset();

                    if (data.error) {
                        this.error.append(data.error).show();
                        form.addClass('error');
                    } else {
                        this.el.modal('close');
                        $('#successFeedback').modal('open');
                    }

                });
            }
        }
    );


    App.Ctrl.Lk.List = can.Control.extend(
        {
            pluginName: 'lk_list'
        },
        {
            init: function () {
                this._init();

                this.beginRequest = false;
            },

            _init: function () {
                this.pager = this.element.find('.js-pager');
            },

            '{window} scroll': function (el, e) {

                if (!this.pager.length || this.beginRequest) {
                    return;
                }

                if (this.pager.offset().top - ($(document).scrollTop() + $(window).height()) <= 400) {

                    this.beginRequest = true;

                    $.ajax({
                        url: this.pager.data('url')
                    }).done(this.proxy(function (data) {

                        this.pager.replaceWith($(data));

                        this.beginRequest = false;
                        this._init();
                    }));

                }
            }
        }
    );


    App.Ctrl.Lk.TopBtn = can.Control.extend(
        {
            pluginName: 'top_btn'
        },
        {
            init: function () {
                this.btn = this.element;
            },

            '{window} scroll': function (el, e) {

                if (!this.btn.hasClass('shown') && $(document).scrollTop() > 400) {
                    this.btn.addClass('shown');
                } else if ($(document).scrollTop() <= 400) {
                    this.btn.removeClass('shown');
                }
            },

            click: function () {
                $('html, body').animate({scrollTop: 0}, "slow");
            }
        }
    );


    App.Ctrl.Lk.Ref = can.Control.extend(
        {
            pluginName: 'lk_ref'
        },
        {
            init: function () {
                this.requestModal = this.element.find('.js-request-modal');
                this.successModal = this.element.find('.js-success-modal');

                this.requestModal.ajaxLoader();
                new Clipboard('.js-ref-link');

                this._init();
            },

            _init: function () {
                this.form = this.element.find('form');
                this.element.find('form input').numeric({negative: false});
            },

            '.js-request-wd click': function (el, e) {
                e.preventDefault();
                this.form.removeClass('error');
                this.requestModal.modal('open');
            },

            'form submit': function (form, e) {
                e.preventDefault();

                this.requestModal.ajaxl({
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    type: 'POST'
                }).done(this.proxy(function (data) {
                    if (data.success) {
                        this.requestModal.modal('close');
                        this.successModal.modal('open');
                    }
                    this.requestModal.html(data.form);

                    this._init();
                }));
            }
        }
    );


})(jQuery);
