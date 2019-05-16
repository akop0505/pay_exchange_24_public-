function playSound() {

    var src = '/bzz.mp3';

    var playPromise = (new Audio(src)).play();
}


(function($) {

    App.Ctrl.Requests = {};

    App.Ctrl.Requests.Grid = can.Control.extend(
        {
            pluginName: 'requests_grid'
        },
        {
            init: function () {
                this.element.ajaxLoader();

                setInterval(this.proxy(this.getNewRows), 10000);
                setInterval(this.proxy(this.getProcTime), 10000);

                this.nextPage = getURLParam('page');
                this.nextPage = this.nextPage && this.nextPage > 1;
            },

            deleteRow: function (id) {
                this.element.find('tr[data-id="' + id + '"]').remove();
            },

            updateRow: function (id) {

                this.element.ajaxl({
                    url: this.options.getRowUrl + '?id=' + id,
                    type: 'POST'
                }).done(this.proxy(function (data) {

                    var $html = $(data),
                        selector = 'tr[data-id="' + id + '"]',
                        $row = $html.find(selector);

                    if ($row.length) {
                        this.element.find(selector).replaceWith($row);
                    }

                }));
            },

            getNewRows: function () {

                if (this.nextPage) {
                    return;
                }

                var id = this.element.find('tbody .js-item').eq(0).data('id');

                $.ajax({
                    url: this.options.getNewRowsUrl + '?id=' + id,
                    type: 'POST'
                }).done(this.proxy(function (data) {

                    var $html = $(data),
                        $rows = $html.find('tbody .js-item');

                    if ($rows.length) {
                        this.element.find('tbody').prepend($rows);

                        playSound();
                    }

                }));
            },

            getProcTime: function () {
                var ids = [];

                this.element.find('tbody .js-item').each(function (i, el) {
                    ids.push($(this).data('id'));
                });

                $.ajax({
                    url: this.options.getProcTimeUrl,
                    data: {id: ids},
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {

                    for (var id in data) {
                        $('.js-item[data-id='+ id +'] .js-process-time-cell').text(data[id]);
                    }

                }));
            },

            '.js-take click': function (el, e) {
                e.preventDefault();

                if (!confirm('Вы уверены, что хотите взять в обработку заявку?')) {
                    return;
                }

                this.element.ajaxl({
                    url: el.data('url'),
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {
                    this.updateRow(data.id);
                }));
            }
        }
    );


    App.Ctrl.Requests.GridBaseForm = App.Widgets.BootstrapModal.extend({},
        {
            init: function () {
                this._super();

                this.reload = this.element.find('.modal-dialog');
                this.reload.ajaxLoader();
            },

            initForm: function () {
                this.error = this.element.find('.js-error');
            },

            onShow: function () {

                this.reload.ajaxl({
                    url: this.caller.data('url')
                }).done(this.proxy(function (data) {

                    this.element.find('.js-body').html(data);
                    this.initForm();
                    this.on();

                }));
            },

            'form submit': function (form, e) {
                e.preventDefault();

                this.error.fadeOut('fast');

                this.reload.ajaxl({
                    url: form.attr('action'),
                    data: form.serialize(),
                    type: 'POST',
                    dataType: 'JSON'
                }).done(this.proxy(function (data) {
                    if (data.success && data.id) {
                        App.CtrlInstances.requests_grid.updateRow(data.id);
                        this.hide();
                    } else if (data.error) {
                        this.error.html(data.error).fadeIn();
                    }
                }));
            }
        }
    );


    App.Ctrl.Requests.CommentForm = App.Ctrl.Requests.GridBaseForm.extend({pluginName: 'requests_CommentForm'}, {});

    App.Ctrl.Requests.AmountForm = App.Ctrl.Requests.GridBaseForm.extend({pluginName: 'requests_AmountForm'}, {});

    App.Ctrl.Requests.CommentForm = App.Ctrl.Requests.GridBaseForm.extend({pluginName: 'requests_CompleteForm'}, {});

    App.Ctrl.Requests.DeclineForm = App.Ctrl.Requests.GridBaseForm.extend({pluginName: 'requests_DeclineForm'}, {});

    App.Ctrl.Requests.BTCSendForm = App.Ctrl.Requests.GridBaseForm.extend({pluginName: 'requests_SendFunds'}, {});


})(jQuery);
