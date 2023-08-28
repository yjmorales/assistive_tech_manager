'use strict';

/**
 * Manages the bootstrap components.
 */
function BsComponents() {

    // UI Elements.
    const ui = {
        $tooltip: '[data-toggle="tooltip"]',
        $switch: 'input[data-switch="true"]',
        $select2: '.yjmSelect2',
        $dismissCollapsable: '[data-dismiss-collapsable="true"]',
        $dataMask: '[data-mask="1"]',
        $flickity: 'y-carousel',
    };

    /**
     * Front controller of the class.
     */
    function init() {
        $(document).ready(initTooltip);
        $(document).ready(initSwitch);
        $(document).ready(initSelect2);
        $(document).ready(initDataMask);
        $(document).on('click', ui.$dismissCollapsable, dismissCollapsable);
    }

    /**
     * Once the page is loaded it initializes tooltip
     */
    function initTooltip() {
        $(ui.$tooltip).tooltip();
    }

    /**
     * Once the page is loaded it initializes tooltip
     */
    function initSwitch() {
        $(ui.$switch).bootstrapSwitch();
    }

    /**
     * Once the page is loaded it initializes select2 components.
     */
    function initSelect2() {
        const $select = $(ui.$select2),
            multiple = $select.attr('multiple');
        $(ui.$select2).select2(
            {
                placeholder: 'Select an option',
                multiple: multiple,
                theme: 'bootstrap4',
                width: '100%',
                allowClear: true,
            }
        );
    }

    /**
     * Init input masks.
     */
    function initDataMask() {
        $(ui.$dataMask).inputmask();
    }

    /**
     * Closes a collapsable component.
     */
    function dismissCollapsable() {
        $(this).closest('.collapse').collapse('hide');
    }

    this.init = init;
}