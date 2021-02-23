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
        ]
    ],

];
