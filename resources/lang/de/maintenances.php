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

    'title' => 'Wartungen',
    'table' => [
        'head' => [
            'id' => 'ID',
            'title' => 'Titel',
            'status' => 'Status',
            'impact' => 'Einfluss',
            'scheduled_at' => 'Geplant um',
            'end_at' => 'Ende um',
            'reporter' => 'Melder',
        ],
    ],
    'new_maintenance' => [
        'button' => 'Wartung Planen',
        'modal' => [
            'title' => 'Wartung Planen',
            'maintenance_title' => 'Titel',
            'visible' => 'Sichtbar',
            'scheduled_at' => 'Startzeit',
            'end_at' => 'Endzeit',
            'end_hint' => 'Wenn Sie diese Wartung nicht automatisch beenden wollen, geben Sie hier keinen Wert an.',
            'affected_components' => 'Betroffene Komponenten',
            'message' => 'Nachricht',
            'schedule_button' => 'Wartung Planen',
        ]
    ],
    'update_maintenance' => [
        'button' => 'Aktualisieren',
        'modal' => [
            'title' => 'Wartung Aktualisieren',
            'maintenance_title' => 'Titel',
            'status' => 'Status',
            'visible' => 'Sichtbar',
            'scheduled_at' => 'Startzeit',
            'scheduled_hint' => 'Geben Sie einen neuen Wert an, um den vorhandenen zu überschreiben. Wenn Sie den Wert unverändert lassen, wird er nicht aktualisiert.',
            'end_at' => 'Endzeit',
            'end_hint' => 'Geben Sie einen neuen Wert an, um den vorhandenen zu überschreiben. Wenn Sie den Wert unverändert lassen, wird er nicht aktualisiert.',
            'affected_components' => 'Betroffene Komponenten',
            'message' => 'Nachricht',
            'update_button' => 'Update posten',
            'update_button_without_message' => 'Update ohne Meldung',
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
