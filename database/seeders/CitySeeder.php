<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::where('name','Ethiopia')->first();
        $country_id =$country->id;
        if($country_id != null)
        {
            if(!City::where('name', 'Addis Ababa')->exists()){
                City::create([
                    'name'=>'Addis Ababa',
                    'name_am'=>'አ.አ',
                    'country_id'=>$country_id,
                    'description' => 'This is Addis Ababa',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name','Ethiopia')->first();
        $country_id =$country->id;
        if($country_id != null)
        {
            if(!City::where('name', 'Adwa')->exists()){
                City::create([
                    'name'=>'Adwa',
                    'name_am'=>'አድዋ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Adwa',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Wukro')->exists()){
                City::create([
                    'name'=>'Wukro',
                    'name_am'=>'ዉቅሮ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Wukro',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Mekelle')->exists()){
                City::create([
                    'name'=>'Mekelle',
                    'name_am'=>'መቀለ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Mekelle',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Maichew')->exists()){
                City::create([
                    'name'=>'Maichew',
                    'name_am'=>'ማይጨው',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Maichew',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Korem')->exists()){
                City::create([
                    'name'=>'Korem',
                    'name_am'=>'ኮረም',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Korem',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Adigrat')->exists()){
                City::create([
                    'name'=>'Adigrat',
                    'name_am'=>'አዲግራት',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Adigrat',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Axum')->exists()){
                City::create([
                    'name'=>'Axum',
                    'name_am'=>'አክሱም',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Axum',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Shire')->exists()){
                City::create([
                    'name'=>'Shire',
                    'name_am'=>'ሽሬ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Shire',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Alamata')->exists()){
                City::create([
                    'name'=>'Alamata',
                    'name_am'=>'አላማታ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Alamata',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name','Ethiopia')->first();
        $country_id =$country->id;
        if($country_id != null)
        {
            if (!City::where('name', 'Adama')->exists()) {
                    City::create([
                        'name' => 'Adama',
                        'name_am' => 'አዳማ',
                        'country_id' => $country_id,
                        'description' => 'This is the description about Adama',
                        'description_am'=>'',
                        'name_fr'=>'',
                        'description_fr'=>'',
                        'name_it'=>'',
                        'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Modjo')->exists()){
                City::create([
                    'name'=>'Modjo',
                    'name_am'=>'ሞጆ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Modjo',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Metu')->exists()){
                City::create([
                    'name'=>'Metu',
                    'name_am'=>'መቱ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Metu',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Fiche')->exists()){
                City::create([
                    'name'=>'Fiche',
                    'name_am'=>'ፍቼ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Fiche',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Bule Hora')->exists()){
                City::create([
                    'name'=>'Bule Hora',
                    'name_am'=>'ቡሌ ሆራ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Bule Hora',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Bonga')->exists()){
                City::create([
                    'name'=>'Bonga',
                    'name_am'=>'ቦንጋ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Bonga',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Agaro')->exists()){
                City::create([
                    'name'=>'Agaro',
                    'name_am'=>'አጋሮ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Agaro',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Dembi Dolo')->exists()){
                City::create([
                    'name'=>'Dembi Dolo',
                    'name_am'=>'ደምቢ ዶሎ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Dembi Dolo',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Jimma')->exists()) {
                City::create([
                    'name' => 'Jimma',
                    'name_am' => 'ጂማ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Jimma',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Shashamane')->exists()) {
                City::create([
                    'name' => 'Shashamane',
                    'name_am' => 'ሻሸመኔ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Shashamane',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Bishoftu')->exists()){
                City::create([
                    'name'=>'Bishoftu',
                    'name_am' => 'ቢሾፍቱ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Bishoftu',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Nekemte')->exists()){
                City::create([
                    'name'=>'Nekemte',
                    'name_am'=>'ነቀምቴ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Nekemte',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Asella')->exists()){
                City::create([
                    'name'=>'Asella',
                    'name_am'=>'አሰላ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Asella',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Sebeta')->exists()){
                City::create([
                    'name'=>'Sebeta',
                    'name_am'=>'ሰበታ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Sebeta',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Burayu')->exists()){
                City::create([
                    'name'=>'Burayu',
                    'name_am'=>'ቡራዩ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Burayu',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Ambo')->exists()){
                City::create([
                    'name'=>'Ambo',
                    'name_am'=>'አምቦ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Ambo',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Arsi Negele')->exists()){
                City::create([
                    'name'=>'Arsi Negele',
                    'name_am'=>'አርሲ ነገሌ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Arsi Negele',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Bale Robe')->exists()){
                City::create([
                    'name'=>'Bale Robe',
                    'name_am'=>'ባሌ ሮቤ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Bale Robe',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Butajira')->exists()){
                City::create([
                    'name'=>'Butajira',
                    'name_am'=>'ቡታጅራ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Butajira',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Ziway')->exists()){
                City::create([
                    'name'=>'Ziway',
                    'name_am'=>'ዝዋይ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Ziway',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Meki')->exists()){
                City::create([
                    'name'=>'Meki',
                    'name_am'=>'መቂ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Meki',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Negele Borena')->exists()){
                City::create([
                    'name'=>'Negele Borena',
                    'name_am'=>'ነገሌ ቦረና',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Negele Borena',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Chiro')->exists()){
                City::create([
                    'name'=>'Chiro',
                    'name_am'=>'ችሮ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Chiro',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Tepi')->exists()){
                City::create([
                    'name'=>'Tepi',
                    'name_am'=>'ተፒ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Tepi',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Goba')->exists()){
                City::create([
                    'name'=>'Goba',
                    'name_am'=>'ጎባ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Goba',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Gimbi')->exists()){
                City::create([
                    'name'=>'Gimbi',
                    'name_am'=>'ጊምቢ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Gimbi',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Haramaya')->exists()){
                City::create([
                    'name'=>'Haramaya',
                    'name_am'=>'ሃራማያ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Haramaya',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Mizan Teferi')->exists()){
                City::create([
                    'name'=>'Mizan Teferi',
                    'name_am'=>'ሚዛን ተፈሪ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Mizan Teferi',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name','Ethiopia')->first();
        $country_id =$country->id;
        if($country_id != null)
        {
            if(!City::where('name', 'Boditi')->exists()){
                City::create([
                    'name'=>'Boditi',
                    'name_am'=>'ቦዲቲ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Boditi',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Sawla')->exists()){
                City::create([
                    'name'=>'Sawla',
                    'name_am'=>'ሳውላ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Sawla',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }

            if(!City::where('name', 'Aleta Wendo')->exists()){
                City::create([
                    'name'=>'Aleta Wendo',
                    'name_am'=>'አለታ ዎንዶ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Aleta Wendo',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Jinka')->exists()){
                City::create([
                    'name'=>'Jinka',
                    'name_am'=>'ጂንካ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Jinka',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Wolaita Dimtu')->exists()){
                City::create([
                    'name'=>'Wolaita Dimtu',
                    'name_am'=>'ዎላይታ ዲምቱ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Wolaita Dimtu',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Awassa')->exists()) {
                City::create([
                    'name' => 'Awassa',
                    'name_am' => 'አዋሳ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Awassa',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Sodo')->exists()) {
                City::create([
                    'name' => 'Sodo',
                    'name_am' => 'ሶዶ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Sodo',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Arba Minch')->exists()) {
                City::create([
                    'name' => 'Arba Minch',
                    'name_am' => 'አርባ ምንጭ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Arba Minch',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Hosaena')->exists()){
                City::create([
                    'name'=>'Hosaena',
                    'name_am'=>'ሆሳና',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Hosaena',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Dilla')->exists()){
                City::create([
                    'name'=>'Dilla',
                    'name_am'=>'ዲላ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Dilla',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Areka')->exists()){
                City::create([
                    'name'=>'Areka',
                    'name_am'=>'አረካ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Areka',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Yirgalem')->exists()){
                City::create([
                    'name'=>'Yirgalem',
                    'name_am'=>'ይርጋለም',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Yirgalem',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Woliso')->exists()){
                City::create([
                    'name'=>'Woliso',
                    'name_am'=>'ዎሊሶ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Woliso',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Welkitie')->exists()){
                City::create([
                    'name'=>'Welkitie',
                    'name_am'=>'ወልቃይት',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Welkitie',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Alaba Kulito')->exists()){
                City::create([
                    'name'=>'Alaba Kulito',
                    'name_am'=>'አላባ ቁሊቶ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Alaba Kulito',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Durame')->exists()){
                City::create([
                    'name'=>'Durame',
                    'name_am'=>'ዱራሜ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Durame',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name','Ethiopia')->first();
        $country_id =$country->id;
        if($country_id != null)
        {
            if (!City::where('name', 'Dire Dawa')->exists()) {
                City::create([
                    'name' => 'Dire Dawa',
                    'name_am' => 'ድሬ ዳዋ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Dire Dawa',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name', 'Ethiopia')->first();
        $country_id = $country->id;
        if ($country_id != null)
        {
            if(!City::where('name', 'Finote Selam')->exists()){
                City::create([
                    'name'=>'Finote Selam',
                    'name_am'=>'ፍኖተ ሰላም',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Finote Selam',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Kobo')->exists()){
                City::create([
                    'name'=>'Kobo',
                    'name_am'=>'ቆቦ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Kobo',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Dangila')->exists()){
                City::create([
                    'name'=>'Dangila',
                    'name_am'=>'ዳንግላ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Dangila',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Mota')->exists()){
                City::create([
                    'name'=>'Mota',
                    'name_am'=>'ሞታ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Mota',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Bahir Dar')->exists()) {

                City::create([
                    'name' => 'Bahir Dar',
                    'name_am' => 'ባህር ዳር',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Bahir Dar',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Dessie')->exists()) {
                    City::create([
                        'name' => 'Dessie',
                        'name_am' => 'ደሴ',
                        'country_id' => $country_id,
                        'description' => 'This is the description about Dessie',
                    'description_am'=>'',
                        'name_fr'=>'',
                        'description_fr'=>'',
                        'name_it'=>'',
                        'description_it'=>''
                ]);
                }
            if(!City::where('name', 'Debre Birhan')->exists()){
                City::create([
                    'name'=>'Debre Birhan',
                    'name_am'=>'ደብረ ብርሃን',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Debre Birhan',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Kombolcha')->exists()){
                City::create([
                    'name'=>'Kombolcha',
                    'name_am'=>'ኮምቦልቻ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Kombolcha',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Debre Tabor')->exists()){
                City::create([
                    'name'=>'Debre Tabor',
                    'name_am'=>'ደብረ ታቡር',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Debre Tabor',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Weldiya')->exists()){
                City::create([
                    'name'=>'Weldiya',
                    'name_am'=>'ወልዲያ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Weldiya',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if (!City::where('name', 'Gondar')->exists()) {
                City::create([
                    'name' => 'Gondar',
                    'name_am' => 'ጎንደር',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Gondar',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name', 'United States')->first();
        $country_id = $country->id;
        if ($country_id != null)
        {
            if(!City::where('name', 'New York')->exists()){
                City::create([
                    'name'=>'New York',
                    'name_am'=>'ኒውዮርክ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about New York',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Washington')->exists()){
                City::create([
                    'name'=>'Washington',
                    'name_am'=>'ዋሺንግተን',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Washington',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
            if(!City::where('name', 'Las Vegas')->exists()){
                City::create([
                    'name'=>'Las Vegas',
                    'name_am'=>'ላስ ቬጋስ',
                    'country_id'=>$country_id,
                    'description' => 'This is the description about Las Vegas',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name', 'France')->first();
        $country_id = $country->id;
        if ($country_id != null)
        {
            if (!City::where('name', 'Paris')->exists()) {
                City::create([
                    'name' => 'Paris',
                    'name_am' => 'ፓሪስ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Paris',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name', 'Spain')->first();
        $country_id = $country->id;
        if ($country_id != null)
        {
            if (!City::where('name', 'Madrid')->exists()) {
                City::create([
                    'name' => 'Madrid',
                    'name_am' => 'ማድሪድ',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Madrid',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name', 'United Kingdom')->first();
        $country_id = $country->id;
        if ($country_id != null)
        {
            if (!City::where('name', 'London')->exists()) {
                City::create([
                    'name' => 'London',
                    'name_am' => 'ሎንዶን',
                    'country_id' => $country_id,
                    'description' => 'This is the description about London',
                    'description_am'=>'',
                    'name_fr'=>'',
                    'description_fr'=>'',
                    'name_it'=>'',
                    'description_it'=>''
                ]);
            }
        }

        $country = Country::where('name', 'Italy')->first();
        $country_id = $country->id;
        if ($country_id != null)
        {
            if (!City::where('name', 'Milan')->exists()) {
                City::create([
                    'name' => 'Milan',
                    'name_am' => 'ሚላን',
                    'country_id' => $country_id,
                    'description' => 'This is the description about Milan',
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
