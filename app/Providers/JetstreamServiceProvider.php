<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        $models = ['incidents', 'maintenances', 'components', 'componentgroups', 'statuses', 'users'];
        $permissions = [];
        $default_permissions = [];

        foreach ($models as $model){
            array_push($permissions, 'read:'.$model);
            array_push($default_permissions, 'read:'.$model);

            array_push($permissions, 'add:'.$model);
            array_push($permissions, 'edit:'.$model);
            array_push($permissions, 'delete:'.$model);
        }

        Jetstream::permissions($permissions);
        Jetstream::defaultApiTokenPermissions($default_permissions);
    }
}
