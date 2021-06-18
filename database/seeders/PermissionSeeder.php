<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Role::findByName('super_admin')->delete();
            Role::findByName('admin')->delete();
            Role::findByName('reporter')->delete();
        }catch (Exception $exception){}

        Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $reporter = Role::create(['name' => 'reporter']);

        $models = ['incidents', 'components', 'componentgroups', 'metrics', 'metric_points', 'statuses', 'users', 'subscribers'];

        $reporterModelsShow = ['incidents', 'components', 'componentgroups', 'metrics', 'metric_points', 'statuses', 'subscribers'];
        $reporterModelsAdd = ['incidents'];
        $reporterModelsEdit = ['incidents', 'components', 'metric_points'];
        $reporterModelsDelete = ['incidents'];

        /**
         * @var $permissions Permission[]
         */
        $permissions = [];

        foreach ($models as $model){
            array_push($permissions, Permission::create(['name' => 'read_'.$model]));
            array_push($permissions, Permission::create(['name' => 'add_'.$model]));
            array_push($permissions, Permission::create(['name' => 'edit_'.$model]));
            array_push($permissions, Permission::create(['name' => 'delete_'.$model]));
        }

        foreach ($permissions as $permission){
            $permission->assignRole($admin);

            if(str_starts_with($permission->name, 'read_') && in_array(explode('_', $permission->name)[1], $reporterModelsShow)){
                $permission->assignRole($reporter);
            }

            if(str_starts_with($permission->name, 'add_') && in_array(explode('_', $permission->name)[1], $reporterModelsAdd)){
                $permission->assignRole($reporter);
            }

            if(str_starts_with($permission->name, 'edit_') && in_array(explode('_', $permission->name)[1], $reporterModelsEdit)){
                $permission->assignRole($reporter);
            }

            if(str_starts_with($permission->name, 'delete_') && in_array(explode('_', $permission->name)[1], $reporterModelsDelete)){
                $permission->assignRole($reporter);
            }
        }

        User::find(1)->assignRole('super_admin');
        User::find(2)->assignRole('super_admin');
    }
}
