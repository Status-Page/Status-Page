<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */


return [

    /*
    |--------------------------------------------------------------------------
    | Incident Language Lines
    |--------------------------------------------------------------------------
    |
    | Please do not edit these lines, as they are managed by our translation
    | system. Thank you.
    |
    */

    'title' => 'Incidents',
    'table' => [
        'head' => [
            'title' => 'Title',
            'status' => 'Status',
            'impact' => 'Impact',
            'reporter' => 'Reporter',
        ],
    ],
    'new_incident' => [
        'button' => 'New Incident',
        'modal' => [
            'title' => 'Create Incident',
            'incident_title' => 'Title',
            'status' => 'Status',
            'impact' => 'Impact',
            'visible' => 'Visible',
            'message' => 'Message',
            'open_button' => 'Open Incident',
        ]
    ],
    'update_incident' => [
        'button' => 'Update',
        'modal' => [
            'title' => 'Update Incident',
            'incident_title' => 'Title',
            'status' => 'Status',
            'impact' => 'Impact',
            'visible' => 'Visible',
            'message' => 'Message',
            'update_button' => 'Post Update',
        ]
    ],
    'delete_incident' => [
        'button' => 'Delete',
        'modal' => [
            'title' => 'Delete Incident',
            'text_r1' => 'Are you sure, you want to delete the Incident ":title"?',
            'text_r2' => 'Be aware, that this could cause temporarily errors on your main page.',
            'delete_button' => 'Delete Incident',
        ]
    ],

];
