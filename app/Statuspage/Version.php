<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage;


use App\Models\CachedVersionData;
use App\Statuspage\API\ResponseGenerator;
use Illuminate\Support\Facades\Http;

class Version
{
    public static function getVersion(){
        return 'v1.9.7';
    }

    public static function fetchLatestVersion(){
        $lasttag = preg_replace("/\s/", "", Http::get('https://raw.githubusercontent.com/Status-Page/Status-Page/master/VERSION')->body());
        $formatted_lasttag = $lasttag == Version::getVersion() ? Version::getVersion() : $lasttag;
        CachedVersionData::getEntry()->setLatestVersion($formatted_lasttag);
    }

    public static function getLatestVersion() {
        $lasttag = CachedVersionData::getEntry()->getLatestVersion();

        $response = ResponseGenerator::generateMetaData(Version::getVersion(), array(
            'on_latest' => Version::getVersion() == $lasttag,
            'git' => (object) array(
                'tag' => Version::getVersion(),
                'last_tag' => $lasttag
            )
        ));

        return $response;
    }
}
