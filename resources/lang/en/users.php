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

    'title' => 'Users',
    'table' => [
        'head' => [
            'name' => 'Name',
            'email' => 'E-Mail',
            'deactivated' => 'Deactivated',
            'role' => 'Role',
        ],
    ],
    'new_user' => [
        'button' => 'Add User',
        'modal' => [
            'title' => 'Add User',
            'name' => 'Name',
            'email' => 'E-Mail',
            'password' => 'Password',
            'deactivated' => 'Deactivated',
            'role' => 'Role',
            'save_button' => 'Save',
        ]
    ],
    'update_user' => [
        'button' => 'Update',
        'modal' => [
            'title' => 'Update User',
            'name' => 'Name',
            'email' => 'E-Mail',
            'email_hint' => 'Read only',
            'password' => 'Password',
            'password_hint' => 'Updates only if you set a value.',
            'deactivated' => 'Deactivated',
            'role' => 'Role',
            'update_button' => 'Update',
        ]
    ],
    'delete_user' => [
        'button' => 'Delete',
        'modal' => [
            'title' => 'Delete User',
            'text_r1' => 'Are you sure, you want to delete the User ":name"?',
            'text_r2' => 'This cannot be undone!',
            'delete_button' => 'Delete User',
        ]
    ],

];
