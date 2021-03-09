<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Statuspage;


use Auth;
use ConfigCat\ConfigCatClient;
use ConfigCat\User;

class GlobalConfig
{
    public static function uniquePageID(){
        return hash('sha512', config('app.url'));
    }

    public static function uniqueUserID($authUser){
        return hash('sha512', config('app.url').$authUser->id.$authUser->name.$authUser->email);
    }

    public static function getFeature($feature, \App\Models\User $authUser = null){
        if(config('statuspage.use_configcat')){
            $user = new User(self::uniquePageID());
            if($authUser != null){
                $user = new User(self::uniqueUserID($authUser));
            }

            $client = new ConfigCatClient((config('app.env') == 'production' ? 'wd3YCE7v2E2KdmSYIZ36Qw/_-hfoDlPgEGbmjOPv0xfkw' : 'wd3YCE7v2E2KdmSYIZ36Qw/LF6lHJe2iE-TE5LQ90ej7Q'));
            return $client->getValue($feature, false, $user);
        }else{
            return false;
        }
    }

    public static function darkModeEnabled(){
        return self::getFeature('darkmodeAvailable', Auth::user()) && config('statuspage.darkmode');
    }
}
