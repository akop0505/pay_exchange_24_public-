(function ($) {

  let buyInput = $('.js-buy');
  let sellInput = $('.js-sell');


  buyInput.on('input', function () {

    let from = $('.js-currency-sell.active').data('name');

    let sellAmount = sellInput.val(),
      buyAmount = buyInput.val();

    buyAmount = buyAmount.replace(',', '.').replace(/^([^\.]*\.)|\./g, '$1');

    if (/^\.|\d+\..*\.|[^\d\.{1}]/.test(buyAmount)) {
      buyAmount = buyAmount.slice(0, -1);
      $(this).val(buyAmount);
    }

    if (buyAmount) {
      let buy = $('.js-course-buy').text();
      let sell = $('.js-course-sell').text();

      sellAmount = (sell * buyAmount) / buy;


      if (from === 'BTC' || from === 'BCH' || from === 'ETH') {
        amount = sellAmount.toFixed(8);
      } else {
        amount = sellAmount.toFixed(2);
      }

      sellInput.val(amount);

    } else {
      sellInput.val('');
    }

    sellInput
      .trigger('validator:validate')
      .trigger('value:set', {value: sellInput.val()});

    buyInput
      .trigger('value:set', {value: buyInput.val()});
  });

  sellInput.on('input', function () {
    let to = $('.js-currency-buy.active').attr('data-name');
    let sellAmount = sellInput.val(),
      totalAmount = 0;

    sellAmount = sellAmount.replace(',', '.').replace(/^([^\.]*\.)|\./g, '$1');

    if (/^\.|\d+\..*\.|[^\d\.{1}]/.test(sellAmount)) {
      sellAmount = sellAmount.slice(0, -1);
      $(this).val(sellAmount);
    }

    if (sellAmount) {
      let buy = parseFloat($('.js-course-buy').text());
      let sell = parseFloat($('.js-course-sell').text());
      totalAmount = (sellAmount * buy) / sell;

      if (to === 'BTC' || to === 'BCH' || to === 'ETH') {
        summ = totalAmount.toFixed(8);
      } else {
        summ = totalAmount.toFixed(2);
      }

      buyInput.val(summ);

    } else {
      buyInput.val('');
    }

    buyInput
      .trigger('validator:validate')
      .trigger('value:set', {value: buyInput.val()});

    sellInput
      .trigger('value:set', {value: sellInput.val()});
  });

  sellInput.on('paste', function (e) {
    let pastedText;
    let from = $('.js-currency-sell.active').attr('data-name');
    let to = $('.js-currency-buy.active').attr('data-name');

    try {
      pastedText = e.originalEvent.clipboardData.getData('text/plain');
    } catch (z) {
      try {
        pastedText = clipboardData.getData('Text');
      } catch (z) {
      }
    }

    if (pastedText) {
      e.preventDefault();
      sellInput.val(pastedText.replace(/[^.\d]+/g, "").replace(/^([^\.]*\.)|\./g, '$1'));

      let a = sellInput.val();
      a = a.replace(',', '.');
      a = parseFloat(a);

      if (a >= 0) {

        if (from !== 'BTC' && from !== 'BCH' && from !== 'ETH') {

          sellInput.val(a.toFixed(2));

        } else {

          let sum = a.toFixed(8);

          sellInput.val(sum);
        }
      }

      let sellAmount = sellInput.val();

      if (sellAmount) {

        let buy = parseFloat($('.js-course-buy').text());
        let sell = parseFloat($('.js-course-sell').text());

        let totalAmount = (sellAmount * buy) / sell;
        let summ = 0;

        if (to === 'BTC' || to === 'BCH' || to === 'ETH') {
          summ = totalAmount.toFixed(8);
        } else {
          summ = totalAmount.toFixed(2);
        }

        buyInput.val(summ);

      } else {
        buyInput.val('');
      }
    }

    buyInput
      .trigger('validator:validate')
      .trigger('value:set', {value: buyInput.val()});

    sellInput
      .trigger('value:set', {value: sellInput.val()});
  });

  buyInput.on('paste', function (e) {
    let pastedText;
    let from = $('.js-currency-sell.active').attr('data-name');
    let to = $('.js-currency-buy.active').attr('data-name');

    try {
      pastedText = e.originalEvent.clipboardData.getData('text/plain');
    } catch (z) {
      try {
        pastedText = clipboardData.getData('Text');
      } catch (z) {
      }
    }

    if (pastedText) {
      e.preventDefault();
      $(this).val(pastedText.replace(/[^.\d]+/g, "").replace(/^([^\.]*\.)|\./g, '$1'));

      let a = buyInput.val();
      a = a.replace(',', '.');
      a = parseFloat(a);

      if (a >= 0) {

        if (!isNaN(a) && to !== 'BTC' && to !== 'BCH') {
          buyInput.val(a.toFixed(2));
        } else {
          let sum = a.toFixed(8);
          buyInput.val(sum);
        }
      }

      let sellAmount = sellInput.val(),
        buyAmount = buyInput.val();

      if (buyAmount) {
        let buy = $('.js-course-buy').text();
        let sell = $('.js-course-sell').text();
        sellAmount = (sell * buyAmount) / buy;

        if (from === 'BTC' || from === 'BCH' || from === 'ETH') {
          amount = sellAmount.toFixed(8);
        } else {
          amount = sellAmount.toFixed(2);
        }

        sellInput.val(amount);
      } else {
        sellInput.val('');
      }
    }

    sellInput
      .trigger('validator:validate')
      .trigger('value:set', {value: sellInput.val()});

    buyInput
      .trigger('value:set', {value: buyInput.val()});
  });


  App.Ctrl.Exg = {};

  App.Ctrl.Exg.Exch = can.Control.extend(
    {
      pluginName: 'exg_currency'
    },
    {
      init: function () {
        this.allForms = null;
        this.from = null;
        this.to = null;

        this.form = $('.js-form');
        this.info = $('.js-info');

        this.allFrom = this.options.allFrom = $('.js-list-from .js-currency');
        this.allTo = this.options.allTo = $('.js-list-to .js-currency');

        this.switch = this.options.switch = $('.js-switch');

        this.sellIcon = this.element.find('.js-icon-from');
        this.buyIcon = this.element.find('.js-icon-to');

        this.sellInput = this.options.sellInput = this.element.find('.js-sell');
        this.buyInput = this.options.buyInput = this.element.find('.js-buy');

        // courses
        this.course = this.element.find('.js-course-full');
        this.cSell = this.element.find('.js-course-sell');
        this.cBuy = this.element.find('.js-course-buy');
        this.hiddenInputeCBuy = this.element.find('.js-course-buy-hidden');
        this.hiddenInputeCSell = this.element.find('.js-course-sell-hidden');
        this.cSellCurrency = this.element.find('.js-course-sell-currency');
        this.cBuyCurrency = this.element.find('.js-course-buy-currency');


        // amounts
        this.amountFrom = this.element.find('.js-amount-from');
        this.amountFromCurrency = this.element.find('.js-amount-from-currency');
        this.amountTo = this.element.find('.js-amount-to');
        this.amountToCurrency = this.element.find('.js-amount-to-currency');

        this.clearAmounts = () => {
          this.amountFrom.text('...');
          this.amountTo.text('...');
          this.amountFromCurrency.text('');
          this.amountToCurrency.text('');
        };
        this.setAmounts = (f = false, t = false, fc = false, tc = false) => {
          f && this.amountFrom.text(f);
          t && this.amountTo.text(t);
          fc && this.amountFromCurrency.text(fc);
          tc && this.amountToCurrency.text(tc);
        };


        // direction
        this.dFromInput = this.element.find('.js-exchange-form-from');
        this.dToInput = this.element.find('.js-exchange-form-to');

        this.formFields = this.element.find('.js-form-fields-block');

        this.on();

        this.detailReset();

        setInterval(() => this.check(), 3000);
        setInterval(() => this.getData(), 3*60*1000);

        this.initFirstDirection();
      },

      '{sellInput} value:set': function(el, e, data) {
        this.amountFrom.text(data.value);
      },

      '{buyInput} value:set': function(el, e, data) {
        this.amountTo.text(data.value);
      },

      check: function () {
        $.ajax({
          url: '/form/check',
          dataType: 'JSON'
        }).done(data => {

          /******* reserve ***********/
          for (let code in data) {
            $('.js-currency-buy-' + code + ' .js-reserve').text(data[code].reserve);
          }

          let active = $('.js-currency-buy.active');

          if (active.length) {
            let activeCode = active.data('name');

            $('.js-buy').data('reserve', data[activeCode].reserve);
          }


          /******* disable ***********/
          for (let code in data) {

            let enable = data[code].enable,
              el = $('.js-currency-sell-' + code + ' ,.js-currency-buy-' + code);

            if (enable) {
              el.show();
            } else {

              el.hide();

              if (el.hasClass('disabled') || el.hasClass('active')) {
                this.allTo.removeClass('disabled active');
                this.allFrom.removeClass('disabled active');
              }
            }
          }
        });
      },

      initFirstDirection: function () {
        let from = $('.js-currency-sell-BTC'),
          to = $('.js-currency-buy-QWRUB');

        if (from.length === 0) {
          from = this.allFrom.eq(0);
        }
        if (to.length === 0) {
          to = this.allTo.eq(1);
        }

        from.trigger('click');
        to.trigger('click');
      },

      getForm: function (from = this.from.data('name'), to = this.to.data('name')) {
        if (this.allForms === null) {
          $.ajax({
            url: '/form/get-fields'
          }).done(data => {
            this.allForms = $(data);
            this.renderForm(from, to);
          });
        } else {
          this.renderForm(from, to);
        }
      },

      renderForm: function (from, to) {
        let selector = `div[id="${from}||${to}"]`;
        let form = this.allForms.find(selector)[0];
        $('.js-form-fields-block').html(form.innerHTML);
        $('div.exchange__form div.loader').hide();
        this.form.find('label').removeClass('active');
        this.form.trigger('validator:reset');
        this.form.find('.js-number').numeric();
      },

      getData: function () {

        $.ajax({
          url: '/form/get-exchange-limit',
          data: {from: this.from.data('name'), to: this.to.data('name')},
          dataType: 'JSON'
        }).done(data => {

          if (data.success) {

            this.sellInput
              .data('min-value', data.minLimit)
              .data('max-value', data.maxLimit)
              .data('currency', data.currency)
              .attr('placeholder', 'min: ' + data.minLimit + ' ' + data.currency);

            this.buyInput.data('reserve', data.reserve);

            this.cSell.text(data.in);
            this.cBuy.text(data.out);
            this.hiddenInputeCSell.val(data.in);
            this.hiddenInputeCBuy.val(data.out);
            this.cSellCurrency.text(data.inCurrency);
            this.cBuyCurrency.text(data.outCurrency);
          }

        });

      },

      onCurrencyClick: function () {
        $('div.exchange__form div.loader').show();

        this.detailReset();

        this.from = $('.js-currency-sell.active');
        this.to = $('.js-currency-buy.active');

        if (this.from.length) {
          this.sellIcon.attr('src', '/images/' + this.from.data('name') + '.png').show();
          this.setAmounts(false, false, this.from.data('name'));
        }

        if (this.to.length) {
          this.buyIcon.attr('src', '/images/' + this.to.data('name') + '.png').show();
          this.setAmounts(false, false, false, this.to.data('name'));
        }

        if (this.from.length && this.to.length) {

          this.sellInput.attr('disabled', false);
          this.buyInput.attr('disabled', false);

          this.dFromInput
            .data('name', this.from.data('name'))
            .data('isCash', this.from.data('isCash'))
            .val(this.from.data('name'));

          this.dToInput
            .data('name', this.to.data('name'))
            .data('isCash', this.to.data('isCash'))
            .val(this.to.data('name'));

          this.getForm();
          this.getData();
        }
      },

      checkHideForm: function (el) {
        if (el.is('.disabled')) {
          this.allTo.removeClass('disabled active');
          this.allFrom.removeClass('disabled active');
        }
      },

      detailReset: function () {
        this.form.find('label').removeClass('active');
        this.form.trigger('validator:reset');
        this.formFields.html('');
        this.sellIcon.hide();
        this.buyIcon.hide();
        this.sellInput.attr('disabled', true);
        this.buyInput.attr('disabled', true);
        this.course.find('span').text('');
        this.clearAmounts();
      },

      '{allFrom} click': function ($item, e) {

        let from = $item,
          index = from.index(),
          to = this.allTo.eq(index);

        this.checkHideForm(from);

        this.allFrom.removeClass('active');
        from.addClass('active');
        this.allTo.removeClass('disabled');
        to.addClass('disabled');

        this.onCurrencyClick();
      },

      '{allTo} click': function ($item, e) {

        let to = $item,
          index = to.index(),
          from = this.allFrom.eq(index);

        this.checkHideForm(to);

        this.allTo.removeClass('active');
        to.addClass('active');
        this.allFrom.removeClass('disabled');
        from.addClass('disabled');

        this.onCurrencyClick();
      },

      '{switch} click': function (el, e) {

        this.from = $('.js-currency-sell.active');
        this.to = $('.js-currency-buy.active');

        if (this.from.length && this.to.length) {

          let newFrom = this.element.find('.js-currency-sell-' + this.to.data('name'));
          let newTo = this.element.find('.js-currency-buy-' + this.from.data('name'));

          if (newFrom.length && newTo.length) {
            newFrom.trigger('click');
            newTo.trigger('click');
          }
        }
      }
    }
  );

  App.Ctrl.Exg.Form = can.Control.extend(
    {
      pluginName: 'exg_form'
    },
    {
      init: function () {

        this.confirmPopupSubmitBtn = this.options.confirmPopupSubmitBtn = $('.js-confirm-bid-form');
        this.formSubmitBtn = this.element.find('.js-submit-btn');

        this.form = this.element;
        this.fromInput = this.element.find('.js-exchange-form-from');
        this.toInput = this.element.find('.js-exchange-form-to');
        this.confirmModal = $('#confirmBidModal');
        this.successModal = $('#successBidModal');

        this.confirmText = this.successModal.find('.js-text');

        this.form.ajaxLoader();
        this.confirmModal.ajaxLoader();
        this.form.formValidate(() => this.onFormValidate());

        this.on();

        this.toInput = this.element.find('.js-exchange-form-to');
      },

      onFormValidate: function () {
        this.confirmModal.modal('open');
      },

      sendForm: function () {

        this.confirmModal.trigger('loader.begin');

        $.ajax({
          url: this.form.attr('action'),
          data: this.form.serialize(),
          type: 'POST',
          dataType: 'JSON'
        }).done((data) => {
          if (data.success) {
            this.setConfirmText();
            this.confirmModal.modal('close');
            this.successModal.modal('open');
          }
        }).always(() => {
          this.confirmModal.trigger('loader.end');
        });
      },

      setConfirmText: function (text) {

        if (this.fromInput.data('isCash')) {
          this.confirmText.text('Заявка успешно создана, и скоро с Вами свяжется оператор для уточнения деталей обмена. Пожалуйста, ожидайте.');
        } else if (this.toInput.data('isCash')) {
          this.confirmText.text('Заявка успешно создана. Далее Вам требуется перевести криптовалюту на кошелек сервиса. Для получения номера кошелька, пожалуйста, напишите в чат оператору и следуйте его инструкциям. Спасибо.');
        } else if (this.fromInput.data('name') === 'BTC') {
          this.confirmText.text('Ваша заявка будет обработана в течение 30 минут(c момента получения 1го подтверждения сети BTC о Вашем переводе)');
        } else if (text) {
          this.confirmText.text(text);
        }
      },

      '{confirmPopupSubmitBtn} click': function (btn, e) {
        e.preventDefault();
        this.sendForm();
      },

      '.input-field click': function (el, e) {
        el.find('input').trigger('focus');
      },

      'input focusout': function (el, e) {
        if (el.val().length === 0) {
          el.closest('.input-field').find('label').removeClass('active');
        }
      }
    }
  );

  let exchanger = new App.Ctrl.Exg.Exch('.js-exchanger');
})(jQuery);
