export const stickButton = () => {
    let reservationBtn = $("#stickyReservation");

    const showBtn = () => reservationBtn.addClass("visible");
    const hideBtn = () => reservationBtn.removeClass("visible");

    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            showBtn();
        } else {
            hideBtn();
        }
    });
}