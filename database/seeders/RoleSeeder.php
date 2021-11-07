<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::where('name', 'SuperAdmin')->exists()){
            Role::create([
                'name'=>'SuperAdmin',
                'description' => 'Role given to the administrator of the portal. Only one user can have SuperAdministrator role through out the system.'
            ]);
        }
        if(!Role::where('name', 'Author')->exists()){
            Role::create([
                'name'=>'Author',
                'description' => 'Role given to the content author.'
            ]);
        }
        if(!Role::where('name', 'Editor')->exists()){
            Role::create([
                'name'=>'Editor',
                'description' => 'Role given to the content Editor.'
            ]);
        }
        if(!Role::where('name', 'Publisher')->exists()){
            Role::create([
                'name'=>'Publisher',
                'description' => 'Role given to the content Publisher.'
            ]);
        }
    }
}
