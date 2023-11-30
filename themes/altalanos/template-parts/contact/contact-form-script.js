jQuery(document).ready(function ($) {
    var form = $('#contact_form');

    $("[name='name'], [name='email'], [name='message']", form).on('blur', validateFields);

    form.on('submit', function (event) {
        var isValid = true;
        var firstInvalidField = null;

        $("[name='name'], [name='email'], [name='message']", form).each(function () {
            if (!isValid) return;  // If a previous field was invalid, skip validation of the rest
            if (!validateField(this)) {
                if (!firstInvalidField) {
                    firstInvalidField = this;
                }
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault();
            firstInvalidField.reportValidity(); // Report the validity to show the error
            firstInvalidField.focus();  // Focus only when the form is being submitted
        }
    });

    function validateFields() {
        validateField(this);
    }

    function validateField(field) {
        var isValid = true;
        var fieldName = $(field).attr('name');

        if (fieldName === 'name' || fieldName === 'message') {
            var regex = /[\p{L}\p{N}\p{P}\p{S}\s]+/gu;
            var trimmedValue = $(field).val().trim();

            if (trimmedValue === '' || !regex.test(trimmedValue)) {
                field.setCustomValidity(localizedText['enter_' + fieldName]);
                isValid = false;
            } else {
                field.setCustomValidity('');
            }
        }

        if (fieldName === 'email') {
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test($(field).val())) {
                field.setCustomValidity(localizedText.enter_email);
                isValid = false;
            } else {
                field.setCustomValidity('');
            }
        }

        return isValid;
    }
});
