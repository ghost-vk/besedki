(function ($) {
    $(document).ready(function () {

        // SLIDER
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
            asNavFor: (sliderNav.length) ? '#popupSliderNav' : null,
            respondTo: 'slider',
            arrows: true,
            appendArrows: "#popupSliderArrows",
            prevArrow: "<div class='arrowLeft'><i class=\"fas fa-chevron-circle-left\"></i></div>",
            nextArrow: "<div class='arrowRight'><i class=\"fas fa-chevron-circle-right\"></i></div>"
        });

        if (sliderNav.length) { // If not mobile
            sliderNav.slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: "#popupSlider",
                dots: false,
                arrows: false,
                focusOnSelect: true,
                vertical: true
            });
        }


        // SELECT DURATION
        const durationOptions = [
            { name: '1 час', value: '1' },
            { name: '2 часа', value: '2' },
            { name: '3 часа', value: '3' },
            { name: 'Целый день', value: 'day' }
        ];

        const selectDuration = $('#selectDuration');
        selectDuration.select({
            data: durationOptions
        });


        // DATETIME
        const picker = $('#datetimepicker');
        const datetimeArgs = {
            inline: true,
            format: "d.m.Y H:i",
            minDate: 0,
            withoutCopyright: true,
            todayButton: false,
            // allowTimes: [''],

            // onSelectDate: function($dtp) {
            //     if (!settings.productID.length) {
            //         return; // Показываем, что сначала надо выбрать беседку
            //     }
            //
            //     picker.datetimepicker('toggleLoader');
            //
            //     let data = { // Data to send via AJAX
            //         action: 'get_available_rent_time',
            //         product_id: settings.productID,
            //         rent_date: getYmd(picker),
            //         nonce: bookingDatetime.nonce
            //     }
            //
            //     // console.log(data); // Test
            //
            //     $.post( bookingDatetime.url, data, function (response) {
            //         console.log(response); // Test
            //         setNewTimes(response.times);
            //         picker.datetimepicker('toggleLoader');
            //     });
            // },
        };

        picker.datetimepicker(datetimeArgs); // Starts Datetimepicker
    });
})(jQuery);