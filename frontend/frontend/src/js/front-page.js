(function ($) {

    $(function () {

        // ------------------------------

        let el = $('#js-operator-date');

        function setOperatorTime() {
            let now = new Date(),
                date = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds());

            date.setTime( date.getTime() + 3*3600000);

            let h = String(date.getHours()),
                m = String(date.getMinutes()),
                s = String(date.getSeconds());

            el.text((h.length === 1 ? '0'+h : h) + ':' + (m.length === 1 ? '0'+m : m) + ':' + (s.length === 1 ? '0'+s : s));
        }

        setOperatorTime();
        setInterval(setOperatorTime, 1000);

        // ------------------------


        $('.tabs').tabs({
            onShow: function (tab) {
                history.replaceState({}, '', '#' + tab.attr('id'));
            }
        });

        $('.modal').modal();

        $('.dropdown-trigger').dropdown({
            hover: false,
            constrainWidth: false,
            belowOrigin: true,
            alignment: 'right',
            gutter: 0
        });

        $('.js-lk-hint').dropdown({
            hover: false,
            constrainWidth: false,
            belowOrigin: false,
            alignment: 'left',
            gutter: 20
        });

        // ---------------------------

        $('.js-slider').bxSlider({
            auto: true,
            pager: false,
            responsive: false,
            wrapperClass: 'reviews__wrapper',
            useCSS: false,
            nextText: '',
            prevText: ''
        });

        $('.js-slider-stat').bxSlider({
            mode: 'fade',
            pause: 2000,
            speed: 1000,
            useCSS: true,
            easing: 'ease-out',
            auto: true,
            pager: false,
            responsive: false,
            wrapperClass: 'stats__wrapper',
            nextText: '',
            prevText: ''
        });


        $('.js-str').simplemarquee({
            speed: 20,
            cycles: 'Infinity',
            space: 0,
            delayBetweenCycles: 0,
        });



        // ---------- faq -------------

        $('.js-faq .faq__item').on('click', function (e) {
            var el = $(this);

            el.toggleClass('opened');

        });
    });

})(jQuery);