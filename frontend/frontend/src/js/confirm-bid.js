(function ($) {

  $(function () {

    let $invalid = $('.js-confirm-invalid');
    let $valid = $('.js-confirm-valid');

    //######## confirm bid counter
    let createdTs = Number(window.bidCreated);

    let $min = $('.js-minutes');
    let $sec = $('.js-seconds');

    const bidCounter = () => {

      const nowTs = Math.floor(Date.now() / 1000);

      let diff = nowTs - createdTs;
      let min = diff >= 60 ? Math.floor(diff / 60) : 0;
      let sec = diff >= 60 ? diff - (min * 60) : diff;

      sec = String(60 - sec);


      if (diff >= 900) {
        clearInterval(timer);

        $valid.hide();
        $invalid.show();

        $.ajax({
          url: $invalid.data('url')
        });
      } else {
        $min.text(14 - min);
        $sec.text(sec.length === 1 ? '0' + sec : sec);
      }
    };

    if ($valid.length) {
      var timer = setInterval(() => bidCounter(), 1000);
    }

    //######## /confirm bid counter




    if ($valid.length) {

      // check status

      (function checkStatus() {

        $.ajax({
          url: $valid.data('status-url'),
          dataType: 'JSON'
        })
          .done((data) => {
            if (!data.draft) {
              location.reload(true);
            }
          })
          .always(() => {
            setTimeout(() => checkStatus(), 2000);
          });

      })();


      // copy wallet


      $('.js-copy-req').on('click', function(e) {
        e.preventDefault();
        const req = $(this).closest('tr').find('.js-req');
        req.addClass('copied');
        setTimeout(() => req.removeClass('copied'), 500);
      });

      new Clipboard('.js-copy-req');


      // bank alert modal

      const alertBankModal = $('#alertBankModal');
      if (alertBankModal.length) {
        alertBankModal.modal('open');
      }

    }


    // check status on detail page

    const $detail = $('.js-check-status');

    if ($detail.length) {

      const currentStatus = $detail.data('status');

      (function checkStatusDetail() {

        $.ajax({
          url: $detail.data('status-url'),
          dataType: 'JSON'
        })
          .done((data) => {
            if (data.status !== currentStatus) {
              location.reload(true);
            }
          })
          .always(() => {
            setTimeout(() => checkStatusDetail(), 2000);
          });

      })();

    }

  });

})(jQuery);