(function ($) {
    $(document).ready(function () {
        let popup,
            slider,
            sliderNav;

        popup = $(".popupGallery");
        slider = popup.find("#popupSlider");
        sliderNav = popup.find("#popupSliderNav");

        slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            dots: false,
            asNavFor: '#popupSliderNav',
            // useTransform: false,
            respondTo: 'slider',
            arrows: true,
            appendArrows: "#popupSliderArrows",
            prevArrow: "<div class='arrowLeft'><i class=\"fas fa-chevron-circle-left\"></i></div>",
            nextArrow: "<div class='arrowRight'><i class=\"fas fa-chevron-circle-right\"></i></div>"
        });
        sliderNav.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: "#popupSlider",
            dots: false,
            arrows: false,
            focusOnSelect: true,
            vertical: true
        });
    });
})(jQuery);