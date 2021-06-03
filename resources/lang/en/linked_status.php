<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */


return [

    /*
    |--------------------------------------------------------------------------
    | LinkedStatus Language Lines
    |--------------------------------------------------------------------------
    |
    | Please do not edit these lines, as they are managed by our translation
    | system. Thank you.
    |
    */

    'title_prefix' => 'Linked Status',
    'title' => 'Pages',
    'subtitle' => 'Add external Status Pages to connect components / incidents / maintenances to them.',
    'table' => [
        'head' => [
            'id' => 'ID',
            'domain' => 'Domain',
            'provider' => 'Provider',
            'c_linked_incidents' => 'Create Linked Incidents',
            'c_linked_maintenances' => 'Create Linked Maintenances',
        ],
        'body' => [
            'actions' => [
                'update' => 'Update'
            ]
        ]
    ],
    'modal_create' => [
        'button' => 'Add Page',
        'title' => 'Add Page',
        'domain' => 'Domain',
        'provider' => 'Provider',
        'c_linked_incidents' => 'Create Linked Incidents',
        'c_linked_maintenances' => 'Create Linked Maintenances',
        'submit' => 'Save',
    ],
    'modal_update' => [
        'button' => 'Update',
        'title' => 'Update Page',
        'domain' => 'Domain',
        'provider' => 'Provider',
        'c_linked_incidents' => 'Create Linked Incidents',
        'c_linked_maintenances' => 'Create Linked Maintenances',
        'submit' => 'Update',
    ],
    'modal_delete' => [
        'button' => 'Delete',
        'title' => 'Delete Page',
        'text_r1' => 'Are you sure, you want to delete the Page ":name"?',
        'text_r2' => 'This cannot be undone!',
        'delete_button' => 'Delete Page',
    ]
];
