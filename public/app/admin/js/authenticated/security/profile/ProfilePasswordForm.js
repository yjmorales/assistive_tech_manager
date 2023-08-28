'use strict';

/**
 * Module responsible to manage the profile password form.
 */
function ProfilePasswordForm() {

    const state = {
        modules: {
            Notification: new Notification(),
            LoaderManager: new LoaderManager(),
        }
    };

    /**
     * Holds the UI References.
     * @type {Object}
     */
    const ui = {
        $form: 'form[name="profile_update_password_form"]',
        $btn: $('button[type="submit"]'),
    };

    /**
     * Initializes the module.
     */
    function init() {
        (new ProfilePasswordFormValidator()).init({callback: submit});
    }

    /**
     * @param {jquery} $form
     * @return {void}
     */
    function submit($form) {
        ui.$btn.prop('disabled', true);
        state.modules.LoaderManager.startOverlay();
        $form.submit();
    }

    this.init = init;
}