'use strict';

/**
 * Validates the entity form to change the password.
 */
function AtDeviceTypeFormValidator() {

    /**
     * Holds the UI References.
     * @type {Object}
     */
    const ui = {
        $form: 'form[name="at_device_type_form"]',
    };

    /**
     * Initializes the module.
     */
    function init(config) {
        if (!config.callback) {
            throw 'No callback to execute when form is valid.';
        }
        $.validator.setDefaults({submitHandler: config.callback});
        validate();
    }

    /**
     * Validates the `get email` form.
     */
    function validate() {
        let rules = {
            'user_form[name]': {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
        };

        let messages = {
            'user_form[name]': {
                required: "Please enter a value.",
                minlength: "The value must not be lesser than 2 characters long.",
                maxlength: "The value must not be longer than 255 characters long.",
            },
        };

        $(ui.$form).validate(
            {
                rules: rules,
                messages: messages,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            }
        );
    }

    this.init = init;
}