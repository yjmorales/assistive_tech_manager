'use strict';

/**
 * Module responsible to manage the profile email form.
 */
function ProfileEmailForm() {

    const state = {
        modules: {
            LoaderManager: new LoaderManager(),
        }
    };

    /**
     * Holds the UI References.
     * @type {Object}
     */
    const ui = {
        $form: 'form[name="profile_update_email_form"]',
        $btn: $('button[type="submit"]'),
    };

    /**
     * Initializes the module.
     */
    function init() {
        (new ProfileEmailFormValidator()).init({callback: submit});
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