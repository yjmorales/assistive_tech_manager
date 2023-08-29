'use strict';

/**
 * Validates the entity form.
 */
function ClientFormValidator() {

    /**
     * Holds the UI References.
     * @type {Object}
     */
    const ui = {
        $form: 'form[name="client_form"]',
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
            'client_form[name]': {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            'client_form[lastname]': {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            'client_form[age]': {
                required: true,
                min: 0,
            },
            'client_form[disability]': {
                required: true,
            },
        };

        let messages = {
            'client_form[name]': {
                required: "Please enter a value.",
                minlength: "The value must not be lesser than 2 characters long.",
                maxlength: "The value must not be longer than 255 characters long.",
            },
            'client_form[lastname]': {
                required: "Please enter a value.",
                minlength: "The value must not be lesser than 2 characters long.",
                maxlength: "The value must not be longer than 255 characters long.",
            },
            'client_form[age]': {
                required: "Please enter a value.",
                min: "The value must not be lesser than 0.",
            },
            'client_form[disability]': {
                required: "Please enter a value.",
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