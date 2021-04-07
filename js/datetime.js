(function ($) {
    let datetimeArgs,
        picker,
        productID,
        settings,
        durationSelector = $('#rentDuration');

    picker = $('#datetimepicker');

    settings = {
        productID: '',
        variationID: '',
        needDate: '', // Date need to rent
        rendDuration: '' // Period need to be rent
    }


    /**
     * Returns formated string from datetimepicker in "Y-m-d", f.e "2000-01-01"
     * @return {string}
     */
    function getYmd() {
        let needDate = picker.datetimepicker('getValue'),
            Y, m, d;

        if (needDate) {
            Y = needDate.getFullYear();
            m = needDate.getMonth() + 1;
            d = needDate.getDate();

            return `${Y}-${m}-${d}`;
        } else {
            return;
        }
    }


    /**
     * Returns formated string from datetimepicker in "Y-m-d H:i:s", f.e "2000-01-01 14:00:00"
     * @return {string}
     */
    function getYmdHis() {
        let needDate = picker.datetimepicker('getValue'),
            Y, m, d, H;

        if (needDate) {
            Y = needDate.getFullYear();
            m = needDate.getMonth() + 1;
            d = needDate.getDate();
            H = needDate.getHours();

            return `${Y}-${m}-${d} ${H}:00:00`;
        } else {
            return;
        }
    }

    function setNewTimes(times) {
        if ( !Array.isArray(times) ) {
            return;
        }
        picker.datetimepicker('setOptions', {
            allowTimes: times
        });
    }

    // Changing statement in settings while change duration period
    durationSelector.change(function () {
        settings.rendDuration = durationSelector.val();

        let selectedEl = $(this).find(':selected');

        settings.variationID = selectedEl.attr('data-id');
        settings.productID = selectedEl.attr('data-parent');
    });

    // Get value
    $('#rent-submit').click(function (e) {
        e.preventDefault();

        var needDate = picker.datetimepicker('getValue'),
            year, month, day, hour, datetimeStr;

        year = needDate.getFullYear();
        month = needDate.getMonth();
        day = needDate.getDate();
        hour = needDate.getHours();

        datetimeStr = `${year}-${month}-${day} ${hour}:00:00`;


        console.log(datetimeStr);

    });

    // Changing available time
    $("#change-settings").click(function (e) {
        e.preventDefault();
        picker.datetimepicker('setOptions', {
            allowTimes: ['13:00', '14:00']
        });
    });


    $("#loader-toggler").click(function (e) {
        e.preventDefault();
        picker.datetimepicker('toggleLoader');
    });

    $("#getTimeBtn").click(function (e) {
        e.preventDefault();

        settings.productID = $(this).attr("data-product"); // Save product ID
        if ( !settings.productID.length ) { // If product ID is not set
            return;
        }

        picker.datetimepicker('toggleLoader');

        let data = { // Data to send via AJAX
            action: 'get_available_rent_time',
            product_id: settings.productID,
            rent_date: getYmd(picker),
            nonce: bookingDatetime.nonce
        }

        $.post( bookingDatetime.url, data, function (response) {
            console.log(response); // Test
            setNewTimes(response.times);
            picker.datetimepicker('toggleLoader');
        });
    });

    $("#rentSubmit").click(function (e) {
        e.preventDefault();
        let datetime, data;

        datetime = getYmdHis(picker);
        if (!datetime) {
            return;
        }

        if (!settings.rendDuration || settings.rendDuration === "0") { // Value isn't set or default value
            return;
        }

        picker.datetimepicker('toggleLoader'); // Show loader

        data = {
            action: 'add_booking_to_cart',
            product_id: settings.productID,
            variation_id: settings.variationID,
            rent_datetime: datetime,
            rent_duration: settings.rendDuration,
            nonce: bookingDatetime.nonce
        }

        // console.log(data); // Test

        $.post( bookingDatetime.url, data, function (response) {
            if (response.status === false) {
                alert('К сожалению, это время уже забронировано');
                picker.datetimepicker('toggleLoader');
                return;
            }
            // console.log(response); // Test
            document.location.href = bookingDatetime.cart_url;
        });
    });

    datetimeArgs = {
        inline: true,
        format: "d.m.Y H:i",
        minDate: 0,
        withoutCopyright: true,
        todayButton: false,
        allowTimes: [''],
        onSelectDate: function($dtp) {
            if (!settings.productID.length) {
                return; // Показываем, что сначала надо выбрать беседку
            }

            picker.datetimepicker('toggleLoader');

            let data = { // Data to send via AJAX
                action: 'get_available_rent_time',
                product_id: settings.productID,
                rent_date: getYmd(picker),
                nonce: bookingDatetime.nonce
            }

            // console.log(data); // Test

            $.post( bookingDatetime.url, data, function (response) {
                console.log(response); // Test
                setNewTimes(response.times);
                picker.datetimepicker('toggleLoader');
            });
        },
    };

    picker.datetimepicker(datetimeArgs); // Starts Datetimepicker

})(jQuery);