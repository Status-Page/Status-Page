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
        'title' => 'Wartungsaktualisierungen für',
        'button' => 'Wartungsaktualisierungen',
        'table' => [
            'head' => [
                'id' => 'ID',
                'update_type' => 'Typ aktualisieren',
                'status_update' => 'Status',
                'text' => 'Text',
                'reporter' => 'Melder',
            ],
        ],
        'update' => [
            'button' => 'Eintrag aktualisieren',
            'modal' => [
                'title' => 'Wartungsaktualisierung Aktualisieren',
                'message' => 'Nachricht',
                'update_button' => 'Aktualisieren',
            ]
        ],
        'delete' => [
            'button' => 'Löschen',
            'modal' => [
                'title' => 'Wartungsaktualisierung Löschen',
                'text_r1' => 'Sind Sie sicher, dass Sie die Aktualisierung :number der Wartung ":title" löschen wollen?',
                'text_r2' => 'Seien Sie sich bewusst, dass dies vorübergehend zu Fehlern auf Ihrer Hauptseite führen kann.',
                'delete_button' => 'Wartungsaktualisierung Löschen',
            ]
        ],
    ],

];
