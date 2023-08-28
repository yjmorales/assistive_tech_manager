'use strict';

/**
 * Manages user list.
 */
function UserList() {


    /**
     * @type {Object} Holds the module state.
     */
    const state = {
        modules: {
            OverlayLoaderManager: new OverlayLoaderManager(),
            Notification: new Notification(),
        }, clicked: {
            rowToRemoveSelector: null
        },
        tableConfig: {
            paging: true,
            lengthChange: true,
            lengthMenu: [[7, 14, 21, -1], [7, 14, 21, "All"]],
            searching: true,
            info: true,
            autoWidth: false,
            responsive: true,
            pageLength: 7,
            compact: true,
            emptyTable: 'No users available',
            oLanguage: {
                'sSearch': 'Search',
                "sLengthMenu": "Show _MENU_",
            },
            aria: {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            rowReorder: true,
            columnDefs: [
                {orderable: true, className: 'reorder', targets: [1, 2]},
                {orderable: false, targets: '_all'},
            ],
            initComplete: onDatatableIsLoaded
        }
    }
    /**
     * UI Elements.
     */
    const ui = {
        // Table
        $table: '.table[data-is-datatable="true"]',

        // Buttons
        $btnRemoveUserFromList: '.btnRemoveUserFromList',

        // Form containers and dialogs.
        $modalDeleteUser: '#modalDeleteUser',
        $modalDeleteUserConfirmationText: '#modalDeleteUserConfirmationText',
        $btnSubmitModalDeleteUser: '#btnSubmitModalDeleteUser',
    };

    /**
     * Subscribes UI Events.
     */
    function init() {
        initDatatable();
        listenUIEvents();
    }

    /**
     * Listens UI Events.
     */
    function listenUIEvents() {
        $(ui.$btnRemoveUserFromList).on('click', openModalDeleteUser);
        $(ui.$btnSubmitModalDeleteUser).on('click', deleteUser);
    }

    /**
     * Inits datatable.
     */
    function initDatatable() {
        if (!$.fn.DataTable.isDataTable(ui.$table)) {
            state.table = $(ui.$table).DataTable(state.tableConfig);
        }
    }

    /**
     * Function used to display the table container after the datatable is rendered.
     */
    function onDatatableIsLoaded() {
        const tableContainer = $(ui.$table).data('container');
        if (tableContainer) {
            $(tableContainer).removeClass('d-none');
        }
    }

    /**
     * Once the user clicks on remove button, this function saves the clicked button id
     * on the state and opens the confirmation modal.
     */
    function openModalDeleteUser() {
        state.clicked.rowToRemoveSelector = `#${$(this).closest('tr').attr('id')}`;
        const $row = $(state.clicked.rowToRemoveSelector);
        const email = $row.data('email');
        const body = `<p>You opted to remove the user <strong>${email}</strong></p>
                       <p>If you remove the user the operation cannot undo.</p> 
                       <p>Do you want to proceed?</p>`;

        $(ui.$modalDeleteUserConfirmationText).html(body);
        $(ui.$modalDeleteUser).modal('show');
    }

    /**
     * Removes a user row.
     */
    function deleteUser() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        state.modules.OverlayLoaderManager.start();
        try {
            const url = $(state.clicked.rowToRemoveSelector).data('url-remove');
            fetch(url, {method: 'POST'})
                .then((response) => response.json())
                .then((data) => {

                    // Notification
                    const email = $(state.clicked.rowToRemoveSelector).data('email');
                    state.modules.Notification.success(`The user <strong>${email}</strong> has been successfully removed.`, 'User removed.');

                    // Btn availability and hiding modal
                    $(ui.$modalDeleteUser).modal('hide');
                    state.modules.OverlayLoaderManager.stop();
                    $btn.prop('disabled', false);

                    // Remove row from datatable
                    const $row = $(state.clicked.rowToRemoveSelector);
                    if (!$row.length) {
                        throw `No row identified by ${state.clicked.rowToRemoveSelector}`;
                    }
                    state.table.row($row).remove().draw();
                });
        }
        catch (e) {
            state.modules.OverlayLoaderManager.stop();
            state.modules.Notification.error('Unable to remove the user.');
            $btn.prop('disabled', false);
        }
    }

    this.init = init;
}