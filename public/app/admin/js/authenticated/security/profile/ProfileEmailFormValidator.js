'use strict';

/**
 * Validates the `profile email` form.
 */
function ProfileEmailFormValidator() {

    /**
     * Holds the UI References.
     *
     * @type {Object}
     */
    const ui = {
        $form: 'form[name="profile_update_email_form"]',
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
     * Validates the form.
     */
    function validate() {
        let rules = {
            'profile_update_email_form[email][first]': {
                required: true,
                email: true,
                minlength: 2,
                maxlength: 255,
            },
            'profile_update_email_form[email][second]': {
                required: true,
                email: true,
                minlength: 2,
                maxlength: 255,
            },
        };

        let messages = {
            'profile_update_email_form[email][first]': {
                required: "Please enter the email.",
                maxlength: "The email must not be longer than 255 characters long.",
                minlength: "The email must not be lesser than 2 characters long.",
            },
            'profile_update_email_form[email][second]': {
                required: "Please enter the email.",
                maxlength: "The email must not be longer than 255 characters long.",
                minlength: "The email must not be lesser than 2 characters long.",
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