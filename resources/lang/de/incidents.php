<?php
return [
    'update_incident' => [
        'modal' => [
            'affected_components_hint' => 'Der Status für die Komponenten wird nicht automatisch gesetzt, wenn Sie diesen Incident aktualisieren. <br> Erst durch das Auflösen des Incidents werden alle Komponenten in den Zustand "Operational" versetzt.',
            'title' => 'Update Vorfall',
            'incident_title' => 'Titel',
            'status' => 'Status',
            'impact' => 'Einfluss',
            'visible' => 'Sichtbar',
            'affected_components' => 'Betroffene Komponenten',
            'message' => 'Nachricht',
            'update_button' => 'Update posten',
        ],
        'button' => 'Update',
    ],
    /*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */
    /*
    |--------------------------------------------------------------------------
    | Incident Language Lines
    |--------------------------------------------------------------------------
    |
    | Please do not edit these lines, as they are managed by our translation
    | system. Thank you.
    |
    */
    'title' => 'Vorfälle',
    'table' => [
        'head' => [
            'title' => 'Titel',
            'status' => 'Status',
            'impact' => 'Einfluss',
            'reporter' => 'Melder',
        ],
    ],
    'new_incident' => [
        'button' => 'Neuer Vorfall',
        'modal' => [
            'title' => 'Vorfall erstellen',
            'incident_title' => 'Titel',
            'status' => 'Status',
            'impact' => 'Einfluss',
            'visible' => 'Sichtbar',
            'affected_components' => 'Betroffene Komponenten',
            'affected_components_hint' => 'Betroffene Komponenten werden automatisch in einen Status gesetzt, der auf den Auswirkungen basiert.',
            'message' => 'Nachricht',
            'open_button' => 'Offener Vorfall',
        ],
    ],
    'delete_incident' => [
        'button' => 'Löschen',
        'modal' => [
            'title' => 'Vorfall löschen',
            'text_r1' => 'Sind Sie sicher, dass Sie den Vorfall ":title" löschen wollen?',
            'text_r2' => 'Seien Sie sich bewusst, dass dies vorübergehend zu Fehlern auf Ihrer Hauptseite führen kann.',
            'delete_button' => 'Vorfall löschen',
        ],
    ],
];
