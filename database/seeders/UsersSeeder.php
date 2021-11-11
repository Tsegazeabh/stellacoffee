<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = array(
            'name' => 'Stella Admin',
            'email' => 'admin@stellacoffee.com',
            'email_verified_at' => Carbon::today(),
            'password' => Hash::make(Crypt::decryptString('eyJpdiI6IlZvandzMTFCak1mNFhEVzRIKzRlZEE9PSIsInZhbHVlIjoiR0dRUzhaRWRHN0FTSm9QSXoyZHc5dz09IiwibWFjIjoiZTFjOWNiYmRhNWY1OTk4MzQxYmMzOGMyMGI0ZTQyMWQzMTQ2OTc4MWJjOTM4MzI4YWYyMWE2MzhhOWNmMzQ5MSIsInRhZyI6IiJ9')),
            'remember_token' => base64_encode(random_bytes(32)),
            'first_name' => 'Stella',
            'middle_name' => 'Plus',
            'last_name' => 'Trading',
            'must_change_password' => false,
            'account_disabled' => 0
        );

        if (User::where('name', $super_admin['name'])->exists()) {
            $user = User::where('name', $super_admin['name'])->first();
            $user->password = $super_admin['password'];
            $user->update();
            if(!$user->is_admin) {
                $super_admin_role = Role::where('name', 'SuperAdmin')->first();
                $user->roles()->sync($super_admin_role->id);
            }
        } else {
            $super_admin_role = Role::where('name', 'SuperAdmin')->first();
            $user = User::create($super_admin);
            $user->roles()->sync($super_admin_role->id);
        }
    }
}
