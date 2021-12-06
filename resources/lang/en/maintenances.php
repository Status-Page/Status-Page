<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */


return [

    /*
    |--------------------------------------------------------------------------
    | Maintenance Language Lines
    |--------------------------------------------------------------------------
    |
    | Please do not edit these lines, as they are managed by our translation
    | system. Thank you.
    |
    */

    'title' => 'Maintenances',
    'table' => [
        'head' => [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'impact' => 'Impact',
            'scheduled_at' => 'Scheduled at',
            'end_at' => 'End at',
            'reporter' => 'Reporter',
        ],
    ],
    'new_maintenance' => [
        'button' => 'Schedule Maintenance',
        'modal' => [
            'title' => 'Schedule Maintenance',
            'maintenance_title' => 'Title',
            'visible' => 'Visible',
            'scheduled_at' => 'Start Time',
            'end_at' => 'End Time',
            'end_hint' => 'If you don\'t want to automatically end this Maintenance, don\'t specify a value here.',
            'affected_components' => 'Affected Components',
            'message' => 'Message',
            'schedule_button' => 'Schedule Maintenance',
        ]
    ],
    'update_maintenance' => [
        'button' => 'Update',
        'modal' => [
            'title' => 'Update Maintenance',
            'maintenance_title' => 'Title',
            'status' => 'Status',
            'visible' => 'Visible',
            'scheduled_at' => 'Start Time',
            'scheduled_hint' => 'Specify a new value to overwrite the existing one. Leaving this as is, wont update this.',
            'end_at' => 'End Time',
            'end_hint' => 'Specify a new value to overwrite the existing one. Leaving this as is, wont update this.',
            'affected_components' => 'Affected Components',
            'message' => 'Message',
            'update_button' => 'Post Update',
            'update_button_without_message' => 'Update without Message',
        ]
    ],
    'maintenance_updates' => [
        'title' => 'Maintenance Updates for',
        'button' => 'Maintenance Updates',
        'table' => [
            'head' => [
                'id' => 'ID',
                'update_type' => 'Update Type',
                'status_update' => 'Status',
                'text' => 'Text',
                'reporter' => 'Reporter',
            ],
        ],
        'update' => [
            'button' => 'Update Entry',
            'modal' => [
                'title' => 'Update Maintenance Update',
                'message' => 'Message',
                'update_button' => 'Update',
            ]
        ],
        'delete' => [
            'button' => 'Delete',
            'modal' => [
                'title' => 'Delete Maintenance Update',
                'text_r1' => 'Are you sure, you want to delete the Update :number for the Maintenance ":title"?',
                'text_r2' => 'Be aware, that this could cause temporarily errors on your main page.',
                'delete_button' => 'Delete Maintenance Update',
            ]
        ],
    ],

];
