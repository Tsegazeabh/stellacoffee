<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country_id = '';
        $country = Country::where('name', '=', 'Ethiopia')->first();
        if (!empty($country)) $country_id = $country->id;
        if (!empty($country_id)) {
            if (!Region::where('name', 'Amhara')->exists()) {
                Region::create([
                    'name'=>'Amhara',
                    'name_am'=>'አማራ',
                    'country_id'=>$country_id,
                    'description' => 'This is Amhara',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Oromia')->exists()) {

                Region::create([
                    'name'=>'Oromia',
                    'name_am'=>'ኦሮምያ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Oromia',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Tigray')->exists()) {

                Region::create([
                    'name'=>'Tigray',
                    'name_am'=>'ትግራይ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Tigray',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Southern Nations, Nationalities and People')->exists()) {

                Region::create([
                    'name'=>'Southern Nations, Nationalities and People',
                    'name_am'=>'የደ.ብ.ብ.ህ.ክ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Southern Nations, Nationalities and People',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Somali')->exists()) {
                Region::create([
                    'name'=>'Somali',
                    'name_am'=>'ሶማሌ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Somali\'',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Addis Ababa')->exists()) {
                Region::create([
                    'name'=>'Addis Ababa',
                    'name_am'=>'አዲስ አበባ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Addis Ababa',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Dire Dawa')->exists()) {
                Region::create([
                    'name'=>'Dire Dawa',
                    'name_am'=>'ድሬ ዳዋ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Dire Dawa',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Afar')->exists()) {
                Region::create([
                    'name'=>'Afar',
                    'name_am'=>'አፋር',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Afar',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Benishangul-Gumuz')->exists()) {

                Region::create([
                    'name'=>'Benishangul-Gumuz',
                    'name_am'=>'ቤንሻንጉል ጉሙዝ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Benishangul-Gumuz',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Gambela')->exists()) {
                Region::create([
                    'name'=>'Gambela',
                    'name_am'=>'ጋምቤላ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Gambela',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Harari')->exists()) {
                Region::create([
                    'name'=>'Harari',
                    'name_am'=>'ሃረሪ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Harari',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!Region::where('name', 'Sidama')->exists()) {
                Region::create([
                    'name'=>'Sidama',
                    'name_am'=>'ሲዳማ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Sidama',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }
    }
}
