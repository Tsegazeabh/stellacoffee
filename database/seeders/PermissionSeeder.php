<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = getAuthorizableModels();
        $validActions = array();
        foreach ($permissions as $model=>$actions)
        {
            foreach ($actions as $action)
            {
                array_push($validActions, $action);
                $per = Permission::firstOrCreate(['model'=>$model, 'action'=>$action]);
            }
            Permission::where('model', $model)->whereNotIn('action', $validActions)->delete();
            $validActions= array();
        }

    }
}
