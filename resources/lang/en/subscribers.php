<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */


return [

    /*
    |--------------------------------------------------------------------------
    | Users Language Lines
    |--------------------------------------------------------------------------
    |
    | Please do not edit these lines, as they are managed by our translation
    | system. Thank you.
    |
    */

    'title' => 'Subscribers',
    'table' => [
        'head' => [
            'id' => 'ID',
            'email' => 'E-Mail',
            'email_verified' => 'E-Mail Verified?',
            'email_verified_at' => 'E-Mail Verified at',
        ],
    ],
    'create' => [
        'button' => 'Add Subscriber',
        'modal' => [
            'title' => 'Add Subscriber',
            'email' => 'E-Mail',
            'save_button' => 'Save',
        ]
    ],
    'resend_verification' => [
        'button' => 'Resend Verification',
        'modal' => [
            'title' => 'Resend Verification E-Mail',
            'text_r1' => 'Are you sure, you want to resend the Verification Email to ":email"?',
            'text_r2' => '',
            'button' => 'Resend Verification',
        ]
    ],
    'delete' => [
        'button' => 'Delete',
        'modal' => [
            'title' => 'Delete Subscriber',
            'text_r1' => 'Are you sure, you want to delete the Subscriber ":email"?',
            'text_r2' => 'This cannot be undone!',
            'delete_button' => 'Delete Subscriber',
        ]
    ],

];
