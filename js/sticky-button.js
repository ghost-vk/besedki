(function ($) {

    (function () {
        let reservationBtn = $("#stickyReservation");

        var showBtn = function () {
            reservationBtn.addClass("visible");
        }

        var hideBtn = function () {
            reservationBtn.removeClass("visible");
        }

        $(window).scroll(function () {

            if ($(this).scrollTop() > 400) {
                showBtn();
            } else {
                hideBtn();
            }
        });
    })();

})(jQuery);