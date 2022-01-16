<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage;


use App\Statuspage\API\ResponseGenerator;
use Illuminate\Support\Facades\Http;

class Version
{
    public static function getVersion(){
        return 'v1.9.4';
    }

    public static function getLatestVersion() {
        $lasttag = preg_replace("/\s/", "", Http::get('https://raw.githubusercontent.com/Status-Page/Status-Page/master/VERSION')->body());
        $formatted_lasttag = $lasttag == Version::getVersion() ? Version::getVersion() : $lasttag;

        $response = ResponseGenerator::generateMetaData(Version::getVersion(), array(
            'on_latest' => Version::getVersion() == $formatted_lasttag,
            'git' => (object) array(
                'tag' => Version::getVersion(),
                'last_tag' => $formatted_lasttag
            )
        ));

        return $response;
    }
}
