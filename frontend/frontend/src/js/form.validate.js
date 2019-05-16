(function ($) {

    $.fn.formValidate = function () {

        let form = $(this),
            errorClass = 'invalid',
            errorSelector = '.invalid',
            successClass = 'valid',
            errors = [];

        bindInputs(getInputs());

        form.on('validator:reset', () => {
            reset();
        });

        form.on('submit', (e) => {

            errors = [];
            let inputs = getInputs();

            validateInputs(inputs);
            bindInputs(inputs);

            if (errors.length !== 0) {
                e.preventDefault();
            }
        });

        function getInputs() {
            return form.find('.js-required');
        }

        function bindInputs(inputs) {

            inputs.off('focusout').on('focusout', function (e) {
                validateInput($(this));
            });

            inputs.off('keyup').on('keyup', function (e) {
                validateInput($(this));
            });

            inputs.off('validator:validate').on('validator:validate', function (e) {
                validateInput($(this));
            });

            inputs.filter('input[type=checkbox]').off('click').on('click', function () {
                validateInput($(this));
            })

        }

        function reset() {
            form.trigger('reset')
                .find(errorSelector).removeClass(errorClass, successClass)
                .find('.error-keeper').text('').hide();
        }

        function makeError($input, text = 'Поле не заполнено') {
            errors.push(text);
            $input
                .parent().addClass(errorClass)
                .find('.error-keeper').text(text).show();
        }

        function makeSuccess($input) {
            $input
                .parent().removeClass(errorClass).addClass(successClass)
                .find('.error-keeper').text('').hide();
        }

        function validateInputs(inputs) {
            inputs.each(function () {
                validateInput($(this));
            });
        }

        function validateInput($input) {

            let value = $input.val().replace(',', '.');

            if (value.length == 0) {

                makeError($input);

            } else if ($input.hasClass('js-email')) {

                if (!(validateEmail(value))) {
                    makeError($input, 'Неверный email');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-checkbox')) {

                if (!$('.js-checkbox').is(':checked')) {
                    makeError($input, 'Вы не согласились с правилами обмена');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-fio-alpha') || $input.hasClass('js-fio-alpha-send')) {

                if (!(validateFioAlpha(value))) {
                    makeError($input, 'Пожалуйста, заполните ФИО полностью');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-btc')) {

                if (!(validateBTC(value))) {
                    makeError($input, 'Не верный номер кошелька');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-bch')) {

                if (!(validateBCH(value))) {
                    makeError($input, 'Не верный номер кошелька');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-xrp')) {

                if (!(validateXRP(value))) {
                    makeError($input, 'Не верный номер кошелька');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-eth')) {

                if (!(validateETH(value))) {
                    makeError($input, 'Не верный номер кошелька');
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-sell')) {

                let minLimit = $input.data('min-value'),
                    maxLimit = $input.data('max-value'),
                    currency = $input.data('currency');

                if (isNaN(Number(value)) || Number(value) < Number(minLimit)) {
                    makeError($input, 'Минимальная сумма обмена ' + minLimit + ' ' + currency)
                } else if (Number(maxLimit) > 0 && Number(value) > Number(maxLimit)) {
                    makeError($input, 'Максимальная сумма обмена ' + maxLimit + ' ' + currency)
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-buy')) {

                let numValue = Number(value),
                    reserve = Number($input.data('reserve'));

                if (value.length === 0 || numValue === 0) {
                    makeError($input);
                }

                (numValue > reserve)
                    ? makeError($input, 'К сожалению, резервов недостаточно')
                    : makeSuccess($input);

            } else if ($input.hasClass('js-tel')) {

                if (!(validateTel(value))) {
                    makeError($input);
                } else {
                    makeSuccess($input);
                }

            } else if ($input.hasClass('js-sber')) {

                if (value.length == 16 || value.length == 17 || value.length == 18) {
                    makeSuccess($input);
                } else {
                    makeError($input);
                }

            } else if ($input.hasClass('js-vtb24')) {

                if (value.length == 20) {
                    makeSuccess($input);
                } else {
                    makeError($input);
                }

            } else if ($input.hasClass('js-yandex')) {

                if (value.length == 12 || value.length == 13 || value.length == 14 || value.length == 15 || value.length == 16) {
                    makeSuccess($input);
                } else {
                    makeError($input);
                }

            } else if ($input.hasClass('js-alpha')) {

                if (value.length == 16) {
                    makeSuccess($input);
                } else {
                    makeError($input);
                }

            } else if ($input.hasClass('js-fiofeed')) {

                if ((validateFioFeed(value))) {
                    makeSuccess($input);
                } else {
                    makeError($input);
                }

            } else {
                makeSuccess($input);
            }
        }


        /******* validators *********/

        function validateTel(value) {
            let tellReg = /^[0-9]+$/;
            if (!tellReg.test(value)) {
                return false;
            } else {
                return true;
            }
        }

        function validateEmail(value) {
            let emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (!emailReg.test(value)) {
                return false;
            } else {
                return true;
            }
        }

        function validateFioAlpha(value) {
            let emailReg = /^[a-zA-Zа-яА-ЯёЁ0-9]+\s+[a-zA-Zа-яА-ЯёЁ0-9]+\s+[a-zA-Zа-яА-ЯёЁ0-9]+$/;
            if (!emailReg.test(value.trim())) {
                return false;
            } else {
                return true;
            }
        }

        function validateFioFeed(value) {
            let emailReg = /^[а-яА-Яa-zA-Z]+$/;
            if (!emailReg.test(value.trim())) {
                return false;
            } else {
                return true;
            }
        }

        function validateBTC(value) {
            let emailReg = /^[0-9]+[a-zA-Z0-9]{19,39}$/;
            if (!emailReg.test(value.trim())) {
                return false;
            } else {
                return true;
            }
        }

        function validateBCH(value) {
            let emailReg = /^[0-9]+[a-zA-Z0-9]{19,39}$/;
            if (!emailReg.test(value.trim())) {
                return false;
            } else {
                return true;
            }
        }

        function validateXRP(value) {
            let emailReg = /^r[a-zA-Z0-9]{33,34}$/;
            if (!emailReg.test(value.trim())) {
                return false;
            } else {
                return true;
            }
        }

        function validateETH(value) {
            let emailReg = /^[0-9]+[a-zA-Z0-9]{41,42}$/;
            if (!emailReg.test(value.trim())) {
                return false;
            } else {
                return true;
            }
        }
    };

})(jQuery);