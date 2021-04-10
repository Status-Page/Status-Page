<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */


return [

    /*
    |--------------------------------------------------------------------------
    | UptimeRobot Language Lines
    |--------------------------------------------------------------------------
    |
    | Please do not edit these lines, as they are managed by our translation
    | system. Thank you.
    |
    */

    'title_prefix' => 'Uptime Robot',
    'title' => 'Monitors',
    'subtitle' => 'Note: Data shown here is updated every minute.',
    'table' => [
        'head' => [
            'id' => 'ID',
            'monitor_id' => 'Monitor ID',
            'name' => 'Name',
            'component' => 'Component',
            'metric' => 'Metric',
            'data_import' => 'Data Import',
        ],
        'body' => [
            'data_import_active' => 'Active',
            'data_import_paused' => 'Paused',
            'actions' => [
                'update' => 'Update'
            ]
        ]
    ],
    'modal_update' => [
        'title' => 'Update Monitor',
        'component' => 'Component',
        'metric' => 'Metric',
        'submit' => 'Update',
    ]
];
