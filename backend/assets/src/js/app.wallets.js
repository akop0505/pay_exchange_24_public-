(function($) {

    App.Ctrl.Wallets = {};

    App.Ctrl.Wallets.Form = can.Control.extend(
        {
            pluginName: 'wallets_form'
        },
        {
            init: function () {
                this.type = this.element.find('.js-type');
                this.nameInput = this.element.find('.js-curr-input');
                this.nameSelect = this.element.find('.js-curr-select');

                this.updateState();
            },

            '.js-type change': function (el, e) {
                this.updateState();
            },

            updateState: function () {
                if (this.type.val() == 1) {
                    this.nameInput.prop('disabled', true).closest('.form-group').hide();
                    this.nameSelect.prop('disabled', false).closest('.form-group').show();
                } else {
                    this.nameSelect.prop('disabled', true).closest('.form-group').hide();
                    this.nameInput.prop('disabled', false).closest('.form-group').show();
                }
            }
        }
    );



    App.Ctrl.Wallets.GridBaseForm = App.Widgets.BootstrapModal.extend({},
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
                    if (data.success) {
                        this.hide();
                        location.reload(true);
                    } else if (data.error) {
                        this.error.html(data.error).fadeIn();
                    }
                }));
            }
        }
    );


    App.Ctrl.Autobalance.EditField = can.Control.extend(
      {
          pluginName: 'wallet_editField'
      },
      {
          init: function () {

              this.viewAria = this.options.viewAria = this.element.find('.js-view-aria');
              this.editAria = this.options.editAria = this.element.find('.js-edit-aria');
              this.editInput = this.options.editInput = this.element.find('.js-edit-input');

              this.on();

              this.editInput.filter_input({regex:'[0-9]+'});

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

                  this.hideEdit();

              })).always(this.proxy(function () {

                  this.viewAria.text(this.editInput.val());

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
              if (e.keyCode === 13) {
                  this.save();
              }
          },

          '{editInput} focusout': function (el, e) {
              this.save();
          }
      }
    );


    App.Ctrl.Wallets.List = can.Control.extend(
        {
            pluginName: 'wallets_list'
        },
        {
            init: function () {

            },

            '.js-rotation-check click': function (el, e) {
                $.ajax({
                    url: el.data('url')
                })

            }
        }
    );


    App.Ctrl.Config.Works = can.Control.extend(
      {
          pluginName: 'rotation_config'
      },
      {
          init: function () {

          },

          '.js-enable-btn change': function (el, e) {

              if (el.is(':checked')) {
                  $.ajax({
                      url: this.element.data('enable-url'),
                      data: {enable: el.val()},
                  });
              }

          }
      }
    );


    App.Ctrl.Wallets.ArchiveForm = App.Ctrl.Wallets.GridBaseForm.extend({pluginName: 'wallets_archive_form'}, {});

})(jQuery);
