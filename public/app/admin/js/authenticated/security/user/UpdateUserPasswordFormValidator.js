'use strict';

/**
 * Validates the `new password` form.
 */
function UpdateUserPasswordFormValidator() {

    /**
     * Holds the UI References.
     * @type {Object}
     */
    const ui = {
        $form: 'form#change_password_form',
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
        $(ui.$form).validate(
            {
                rules: {
                    'change_password_form[password][first]': {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                    },
                    'change_password_form[password][second]': {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                    },
                },
                messages: {
                    'change_password_form[password][first]': {
                        required: "Please enter your password.",
                        maxlength: "The password must not be longer than 255 characters long.",
                        minlength: "The password must not be lesser than 2 characters long.",
                    },
                    'change_password_form[password][second]': {
                        required: "Please enter your password.",
                        maxlength: "The password must not be longer than 255 characters long.",
                        minlength: "The password must not be lesser than 2 characters long.",
                    },
                },
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