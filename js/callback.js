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
             * Function disables form fields
             */
            var disableForm = function () {
                elements.btn.prop("disabled", "true");
                elements.name.prop("disabled", "true");
                elements.phone.prop("disabled", "true");
            }


            /**
             * Show modal window with response, and hide after timeout
             * @param response { status : true }
             */
            var showResponse = function (response) {
                let content, notification, state;
                state = store.getState();
                content = {};

                if (response.status === true) {
                    content.icon = '<i class="fas fa-check-square"></i>';
                    content.text = 'В скором времени мы вам перезвоним!';

                    elements.btn.text("Готово!");
                } else {
                    content.icon = '<i class="fas fa-exclamation-circle"></i>';
                    content.text = 'Возникла ошибка!<br />Попробуйте перезагрузить страницу';

                    elements.btn.text("Ошибка");
                }

                notification = new Notification(state.general.notificationContainer, content);
                notification.init(4000);


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
                let phoneNumber, data;

                phoneNumber = libphonenumber.parsePhoneNumber(elements.phone.val(), "RU");
                data = {
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
                    let settings,
                        state,
                        is_valid = validateInput();
                    if ( is_valid ) {
                        // showResponse();
                        state = store.getState();
                        settings = {
                            nonce: state.general.nonce,
                            url: state.general.ajaxUrl,
                            action: "callback_lid"
                        }
                        let query = getFormData();

                        let serverClient = new ServerClient(settings, query);
                        serverClient.get(showResponse);

                        elements.btn.text("Отправка...");
                        disableForm();

                        clearInput();
                    }
                });
            }
            sendForm();
        };

        callback($("#callbackForm"));
    });
})(jQuery);