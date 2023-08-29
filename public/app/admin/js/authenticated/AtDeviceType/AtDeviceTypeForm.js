'use strict';

/**
 * Module responsible to manage the form page.
 */
function AtDeviceTypeForm() {

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
        $form: 'form[name="at_device_type_form"]',
        $btn: $('button[type="submit"]'),
    };

    /**
     * Initializes the module.
     */
    function init() {
        (new AtDeviceTypeFormValidator()).init({callback: submit});
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