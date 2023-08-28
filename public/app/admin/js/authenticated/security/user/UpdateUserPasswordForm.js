'use strict';

/**
 * Module responsible to update the password.
 */
function UpdateUserPasswordForm() {

    /**
     * Holds the UI References.
     * @type {Object}
     */
    const ui = {
        $form: 'form#user_update_password_form',
        $btn: $('button[type="submit"]'),
        $fieldPasswordFirst: $('#change_password_form_password_first'),
        $fieldPasswordSecond: $('#change_password_form_password_second'),
        $info: $('#info'),
    };

    /**
     * Initializes the module.
     */
    function init() {
        (new UpdateUserPasswordFormValidator()).init({callback: submit});
    }

    /**
     * If the form does not have errors this submits the passwords.
     *
     * @param {jquery} $form Form to login the user.
     * @return {void}
     */
    function submit($form) {
         ui.$btn.prop('disabled', true);
        grecaptcha.ready(function () {
            grecaptcha.execute(ui.$info.data('recaptcha-v3-site-key'), {action: 'submit'}).then(function (token) {
                $($form).find('input[name="g-recaptcha-response"]').val(token);
                $form.submit();
            });
        });


    }

    this.init = init;
}