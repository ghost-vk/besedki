(function ($) {
    $(document).ready(function () {

        var callback = function (obj) {
            var elements = {
                check: obj.find(".callback__box"),
                btn: obj.find(".callback__btn button"),
                name: obj.find(".callback__input.name input"),
                phone: obj.find(".callback__input.phone input"),
                agreement: obj.find(".callback__box input")
            };

            var settings = {
                minNameLength: 3, // Name should be minimum 3 symbol length
            }

            var highlightCheckbox = function () {
                elements.check.click(function () {
                    $(this).toggleClass("active");
                });
            }

            highlightCheckbox();

            var showError = function (node) {
                if (!node) {
                    return;
                }
                node.next().addClass("active");
                node.addClass("error-border");
            }

            var hideError = function (node) {
                if (!node) {
                    return;
                }
                node.next().removeClass("active");
                node.removeClass("error-border");
            }

            var validateInput = function () {
                let is_valid = true;

                // Name
                if (elements.name.val().length < settings.minNameLength) {
                    showError(elements.name);
                    is_valid = false;
                } else {
                    hideError(elements.name);
                }

                // Phone
                let inputValue = elements.phone.val();

                if ( inputValue > 0 ) {
                    if (
                        libphonenumber.isValidPhoneNumber(inputValue, 'RU') === true
                        &&
                        libphonenumber.isPossiblePhoneNumber(inputValue, 'RU') === true
                    ) {
                        hideError(elements.phone);
                    } else {
                        showError(elements.phone);
                        is_valid = false;
                    }
                } else {
                    showError(elements.phone);
                    is_valid = false;
                }

                // Policy agreement
                if ( elements.agreement.prop("checked") !== true ) {
                    showError(elements.agreement);
                    elements.agreement.parent().addClass('error-border');
                    is_valid = false;
                } else {
                    hideError(elements.agreement);
                    elements.agreement.parent().removeClass('error-border');
                }

                return is_valid;

            }

            /**
             * Show modal window with response, and hide after timeout
             */
            var showResponse = function () {
                var callbackResponseModal = callbackResponseModal || $("#callbackModal");
                callbackResponseModal.addClass("active");
                setTimeout(function () {
                    callbackResponseModal.removeClass("active");
                }, 2500);
            }

            /**
             * Clear input field
             */
            var clearInput = function () {
                elements.name.val('');
                elements.phone.val('');
                elements.check.click();
                elements.agreement.prop("checked", false);
            }

            /**
             * Get data from callback form
             * @return {Object}
             */
            var getFormData = function () {
                let phoneNumber,
                    data;

                phoneNumber = libphonenumber.parsePhoneNumber(elements.phone.val(), "RU");
                data = {
                    action: "callback_lid",
                    nonce: generalSettings.nonce,
                    name: elements.name.val(),
                    phone: phoneNumber.formatNational()
                }

                return data;
            }

            /**
             * Sending form via ajax or show errors.
             */
            var sendForm = function () {
                elements.btn.click(function () {
                    let is_valid = validateInput();
                    if ( is_valid ) {
                        let data;
                        showResponse();
                        data = getFormData();
                        clearInput();
                        $.post( generalSettings.url, data );
                    }
                });
            }
            sendForm();
        };

        callback($("#callbackForm"));
    });
})(jQuery);