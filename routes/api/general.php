<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use App\Statuspage\API\ResponseGenerator;
use App\Statuspage\Version;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return ResponseGenerator::generateResponse(array(
        'message' => 'Pong!'
    ));
});

Route::get('/version', function () {
    $lasttag = config('app.url') == 'https://status.herrtxbias.me' ? Version::getVersion() : \Illuminate\Support\Facades\Http::get('https://status.herrtxbias.me/api/v1/version');
    $formatted_lasttag = $lasttag == Version::getVersion() ? Version::getVersion() : $lasttag->json()['data'];

    return ResponseGenerator::generateMetaResponse(Version::getVersion(), array(
        'on_latest' => Version::getVersion() == $formatted_lasttag,
        'git' => array(
            'tag' => Version::getVersion(),
            'last_tag' => $formatted_lasttag
        )
    ));
})->name('api.version');
