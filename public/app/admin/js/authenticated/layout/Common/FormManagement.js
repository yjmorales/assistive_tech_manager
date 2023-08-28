'use strict';

/**
 * Controls the form elements. It must be initialized by 'new FormManagement()'
 */
function FormManagement() {

    const state = {
        modules: {
            loaderManager: new LoaderManager(),
        },
    };

    // UI Elements.
    const ui = {
        // Buttons
        $btnClearField: $('button[data-clear-field="true"]'),
        $btnClearForm: $('button[data-clear-form="true"]'),

        // Image Preview
        $imgPreview: '.y-img-preview',
        $fieldImgPreview: 'input[data-show-preview="1"]',

        // Form
        $form: 'form',
    };

    /**
     * Front controller of the class.
     */
    function init() {
        // Clear the form fields
        ui.$btnClearField.on('click', clearField);
        ui.$btnClearForm.on('click', clearForm);
        $(document).on('submit', ui.$form, showLoader);
        $(ui.$fieldImgPreview).on('change', showPreviewImage);
    }

    /**
     * Clear the form fields.
     */
    function clearField() {
        const $inputGroup = $(this).closest('.input-group');
        $inputGroup.find('input').val(null);
        $inputGroup.find('textarea').val(null);
        $inputGroup.find('select').val(null);
    }

    /**
     * Clear the whole form fields.
     */
    function clearForm() {
        const $form = $(this).closest('form');
        $form.find('input').val(null);
        $form.find('textarea').val(null);
        $form.find('select').val(null);
        $form.find('.yjmSelect2').val(null).trigger('change');
    }

    /**
     * Shows the overlay loader while the form is submitted.
     */
    function showLoader() {
        state.modules.loaderManager.startOverlay();
    }

    /**
     * Update selected img on the fly.
     * @return {void}
     */
    function showPreviewImage(e) {
        const input = e.target;
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            $(ui.$imgPreview).attr('src', reader.result);
        }
    }

    this.init = init;
}