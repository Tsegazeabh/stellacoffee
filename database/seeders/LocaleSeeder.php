<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Locale::where('name', 'am')->exists())
        {
            DB::table('locales')->insert(
                [
                    'name' => 'Amharic',
                    'short_code' => 'am',
                    'description' => 'Amharic language'
                ]
            );
        }

        if(!Locale::where('name', 'en')->exists())
        {
            DB::table('locales')->insert(
                [
                    'name' => 'English',
                    'short_code' => 'en',
                    'description' => 'English language'
                ]
            );
        }

    }
}
