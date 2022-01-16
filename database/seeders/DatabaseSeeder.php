<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\DocumentType;
use App\Models\ImportantLink;
use App\Models\PaymentType;
use App\Models\PublicationType;
use App\Models\Region;
use App\Models\Woreda;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\models\User::factory(10)->create();

        // Seed Locales
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UsersSeeder::class,
            LocaleSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            RegionSeeder::class
//            CountrySeeder::class,
//            RegionSeeder::class,
//            ZoneSeeder::class,
//            WoredaSeeder::class,
//            CitySeeder::class,
//            ServiceTypeSeeder::class,
//            PaymentTypeSeeder::class
//            ImportantLinkSeeder::class
        ]);
    }
}
