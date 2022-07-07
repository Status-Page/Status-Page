<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSubscriberPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Role::query()->where('id', '=', 2)->count() == 0)
            return;
        if(Role::query()->where('id', '=', 3)->count() == 0)
            return;

        $admin = Role::findById(2);
        $reporter = Role::findById(3);

        $models = ['subscribers'];

        $reporterModelsShow = ['subscribers'];
        $reporterModelsAdd = [];
        $reporterModelsEdit = [];
        $reporterModelsDelete = [];

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
