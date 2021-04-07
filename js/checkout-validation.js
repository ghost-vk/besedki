(function ($) {
    $(document).ready(function () {
        let fields,
            errors,
            submit,
            validation,
            errorWrapper;

        fields = {
            secondName: $("#billing_last_name"),
            name: $("#billing_first_name"),
            fatherName: $("#billing_father_name"),
            personQty: $("#billing_person_qty"),
            phone: $("#billing_phone"),
            passport: $("#billing_passport_data"),
            policy: $("#checkPolicy")
        }

        errors = {
            secondName: 'Введите вашу фамилию',
            name: 'Введите ваше имя',
            fatherName: 'Введите ваше отчество',
            personQty: 'Сколько вас будет?',
            phone: 'Введите номер телефона',
            passport: 'Введите ваши паспортные данные',
            policy: 'Обязательно согласие с Политикой конфиденциальности'
        }


        // MASK
        fields.passport.mask("9999 999999");

        fields.personQty.on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        fields.phone.on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });


        // ERRORS
        errorWrapper = $("#billingError");

        /**
         * Constructs tag with error text
         * @param errorText {String}
         * @return {HTML}
         */
        const constructError = function (prop) {
            let errorText = errors[prop];
            return `
                <span class="bg-danger d-block rounded p-2 mb-3 text-white"><i class="fas fa-exclamation-circle"></i> ${errorText}</span>
            `;
        }


        // VALIDATIONS

        /**
         * Normal check email
         * @param email
         * @return {boolean}
         */
        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        /**
         * Check no empty string
         * @param str
         * @return {boolean}
         */
        function validateSimpleString(str) {
            if (!str || str.length < 3) {
                return false;
            }
            return true;
        }

        /**
         * Simple validates phone
         * @param str
         * @return {boolean}
         */
        function lazyValidatePhone(str) {
            if (!str || str.length < 8) {
                return false;
            }
            return true;
        }


        /**
         * Validates simple string, f.e. person quantity
         * @param qty
         * @return {boolean}
         */
        function validateSimpleNumber(qty) {
            if ( !qty ) {
                return false;
            }
            let num = parseInt(qty);
            if (!Number.isInteger(num) || num < 1) {
                return false;
            } else {
                return true;
            }
        }


        /**
         * Validates checkbox
         * @param check {jQuery element}
         * @return {boolean}
         */
        function validateCheck(check) {
            if (check.prop("checked") !== true) {
                return false;
            }
            return true;
        }

        /**
         * Validates all fields in field Object
         * @return {boolean}
         */
        function validateFields() {
            let validation,
                data;

            data = {
                status: false,
                errorProp: '',
                errorNode: '',
            }

            for (var prop in fields) {
                let inputValue = fields[prop].val();
                switch (prop) {
                    case 'phone' :
                        validation = lazyValidatePhone(inputValue);
                        break;
                    case 'passport' : // Minimum 8 chars, acceptable in this case (with mask)
                        validation = lazyValidatePhone(inputValue);
                        break;
                    case 'email' :
                        validation = validateEmail(inputValue);
                        break;
                    case 'personQty' :
                        validation = validateSimpleNumber(inputValue);
                        break;
                    case 'policy' :
                        validation = validateCheck(fields[prop]);
                        break;
                    default :
                        validation = validateSimpleString(inputValue);
                        break;
                }
                if (validation === false) {
                    if (prop !== "policy") {
                        fields[prop].parent().parent().addClass('border border-danger');
                    }
                    data.errorProp = prop;
                    data.errorNode = fields[prop];
                    return data;
                } else {
                    if (prop !== "policy") {
                        fields[prop].parent().parent().removeClass('border border-danger');
                    }
                }
            }
            data.status = true;
            return data;
        }



        /**
         * Scroll to node
         * Used here for scroll to error
         * @param node {jQuery object}
         */
        function scrollToError (node) {
            $('html, body').animate({
                scrollTop: node.offset().top - 100
            }, 1);
        }


        submit = $("#checkoutSubmit");

        validation = false;
        submit.click(function (e) {
            if (validation.status === true) { // Bubble away after validation
                return;
            }

            let error;

            e.preventDefault();
            validation = validateFields();
            if (validation.status !== true) { // Validation failed
                error = constructError(validation.errorProp);
                errorWrapper.html(error);
                scrollToError(validation.errorNode);
            } else {
                errorWrapper.html('');
                $(this).trigger('click');
            }
        });

    });
})(jQuery);