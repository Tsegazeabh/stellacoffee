<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Region;
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
        $regionAA = Region::where('name','Addis Ababa')->first();
        $regionAA_id =$regionAA->id;
        if($regionAA_id != null)
        {
            if(!City::where('name', 'Addis Ababa')->exists()){
                City::create([
                    'name'=>'Addis Ababa',
                    'name_lan'=>'አ.አ',
                    'region_id'=>$regionAA_id,
                    'description' => 'This is Addis Ababa',
                    'description_lan' => ''
                ]);
            }
        }

        $regionT = Region::where('name','Tigray')->first();
        $regionT_id =$regionT->id;
        if($regionT_id != null)
        {
            if(!City::where('name', 'Adwa')->exists()){
                City::create([
                    'name'=>'Adwa',
                    'name_lan'=>'አድዋ',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Adwa',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Wukro')->exists()){
                City::create([
                    'name'=>'Wukro',
                    'name_lan'=>'ዉቅሮ',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Wukro',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Mekelle')->exists()){
                City::create([
                    'name'=>'Mekelle',
                    'name_lan'=>'መቀለ',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Mekelle',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Maichew')->exists()){
                City::create([
                    'name'=>'Maichew',
                    'name_lan'=>'ማይጨው',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Maichew',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Korem')->exists()){
                City::create([
                    'name'=>'Korem',
                    'name_lan'=>'ኮረም',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Korem',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Adigrat')->exists()){
                City::create([
                    'name'=>'Adigrat',
                    'name_lan'=>'አዲግራት',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Adigrat',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Axum')->exists()){
                City::create([
                    'name'=>'Axum',
                    'name_lan'=>'አክሱም',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Axum',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Shire')->exists()){
                City::create([
                    'name'=>'Shire',
                    'name_lan'=>'ሽሬ',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Shire',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Alamata')->exists()){
                City::create([
                    'name'=>'Alamata',
                    'name_lan'=>'አላማታ',
                    'region_id'=>$regionT_id,
                    'description' => 'This is the description about Alamata',
                    'description_lan' => ''
                ]);
            }
        }

        $regionOR = Region::where('name','Oromia')->first();
        $regionOR_id =$regionOR->id;
        if($regionOR_id != null)
        {
            if (!City::where('name', 'Adama')->exists()) {
                    City::create([
                        'name' => 'Adama',
                        'name_lan' => 'አዳማ',
                        'region_id' => $regionOR_id,
                        'description' => 'This is the description about Adama',
                        'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Modjo')->exists()){
                City::create([
                    'name'=>'Modjo',
                    'name_lan'=>'ሞጆ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Modjo',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Metu')->exists()){
                City::create([
                    'name'=>'Metu',
                    'name_lan'=>'መቱ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Metu',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Fiche')->exists()){
                City::create([
                    'name'=>'Fiche',
                    'name_lan'=>'ፍቼ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Fiche',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Bule Hora')->exists()){
                City::create([
                    'name'=>'Bule Hora',
                    'name_lan'=>'ቡሌ ሆራ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Bule Hora',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Bonga')->exists()){
                City::create([
                    'name'=>'Bonga',
                    'name_lan'=>'ቦንጋ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Bonga',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Agaro')->exists()){
                City::create([
                    'name'=>'Agaro',
                    'name_lan'=>'አጋሮ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Agaro',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Dembi Dolo')->exists()){
                City::create([
                    'name'=>'Dembi Dolo',
                    'name_lan'=>'ደምቢ ዶሎ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Dembi Dolo',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Jimma')->exists()) {
                City::create([
                    'name' => 'Jimma',
                    'name_lan' => 'ጂማ',
                    'region_id' => $regionOR_id,
                    'description' => 'This is the description about Jimma',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Shashamane')->exists()) {
                City::create([
                    'name' => 'Shashamane',
                    'name_lan' => 'ሻሸመኔ',
                    'region_id' => $regionOR_id,
                    'description' => 'This is the description about Shashamane',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Bishoftu')->exists()){
                City::create([
                    'name'=>'Bishoftu',
                    'name_lan' => 'ቢሾፍቱ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Bishoftu',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Nekemte')->exists()){
                City::create([
                    'name'=>'Nekemte',
                    'name_lan'=>'ነቀምቴ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Nekemte',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Asella')->exists()){
                City::create([
                    'name'=>'Asella',
                    'name_lan'=>'አሰላ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Asella',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Sebeta')->exists()){
                City::create([
                    'name'=>'Sebeta',
                    'name_lan'=>'ሰበታ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Sebeta',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Burayu')->exists()){
                City::create([
                    'name'=>'Burayu',
                    'name_lan'=>'ቡራዩ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Burayu',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Ambo')->exists()){
                City::create([
                    'name'=>'Ambo',
                    'name_lan'=>'አምቦ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Ambo',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Arsi Negele')->exists()){
                City::create([
                    'name'=>'Arsi Negele',
                    'name_lan'=>'አርሲ ነገሌ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Arsi Negele',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Bale Robe')->exists()){
                City::create([
                    'name'=>'Bale Robe',
                    'name_lan'=>'ባሌ ሮቤ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Bale Robe',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Butajira')->exists()){
                City::create([
                    'name'=>'Butajira',
                    'name_lan'=>'ቡታጅራ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Butajira',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Ziway')->exists()){
                City::create([
                    'name'=>'Ziway',
                    'name_lan'=>'ዝዋይ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Ziway',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Meki')->exists()){
                City::create([
                    'name'=>'Meki',
                    'name_lan'=>'መቂ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Meki',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Negele Borena')->exists()){
                City::create([
                    'name'=>'Negele Borena',
                    'name_lan'=>'ነገሌ ቦረና',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Negele Borena',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Chiro')->exists()){
                City::create([
                    'name'=>'Chiro',
                    'name_lan'=>'ችሮ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Chiro',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Tepi')->exists()){
                City::create([
                    'name'=>'Tepi',
                    'name_lan'=>'ተፒ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Tepi',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Goba')->exists()){
                City::create([
                    'name'=>'Goba',
                    'name_lan'=>'ጎባ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Goba',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Gimbi')->exists()){
                City::create([
                    'name'=>'Gimbi',
                    'name_lan'=>'ጊምቢ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Gimbi',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Haramaya')->exists()){
                City::create([
                    'name'=>'Haramaya',
                    'name_lan'=>'ሃራማያ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Haramaya',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Mizan Teferi')->exists()){
                City::create([
                    'name'=>'Mizan Teferi',
                    'name_lan'=>'ሚዛን ተፈሪ',
                    'region_id'=>$regionOR_id,
                    'description' => 'This is the description about Mizan Teferi',
                    'description_lan' => ''
                ]);
            }
        }

        $regionSNNP = Region::where('name','Southern Nations, Nationalities and People')->first();
        $regionSNNP_id =$regionSNNP->id;
        if($regionSNNP_id != null)
        {
            if(!City::where('name', 'Boditi')->exists()){
                City::create([
                    'name'=>'Boditi',
                    'name_lan'=>'ቦዲቲ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Boditi',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Sawla')->exists()){
                City::create([
                    'name'=>'Sawla',
                    'name_lan'=>'ሳውላ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Sawla',
                    'description_lan' => ''
                ]);
            }

            if(!City::where('name', 'Aleta Wendo')->exists()){
                City::create([
                    'name'=>'Aleta Wendo',
                    'name_lan'=>'አለታ ዎንዶ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Aleta Wendo',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Jinka')->exists()){
                City::create([
                    'name'=>'Jinka',
                    'name_lan'=>'ጂንካ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Jinka',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Wolaita Dimtu')->exists()){
                City::create([
                    'name'=>'Wolaita Dimtu',
                    'name_lan'=>'ዎላይታ ዲምቱ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Wolaita Dimtu',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Awassa')->exists()) {
                City::create([
                    'name' => 'Awassa',
                    'name_lan' => 'አዋሳ',
                    'region_id' => $regionSNNP_id,
                    'description' => 'This is the description about Awassa',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Sodo')->exists()) {
                City::create([
                    'name' => 'Sodo',
                    'name_lan' => 'ሶዶ',
                    'region_id' => $regionSNNP_id,
                    'description' => 'This is the description about Sodo',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Arba Minch')->exists()) {
                City::create([
                    'name' => 'Arba Minch',
                    'name_lan' => 'አርባ ምንጭ',
                    'region_id' => $regionSNNP_id,
                    'description' => 'This is the description about Arba Minch',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Hosaena')->exists()){
                City::create([
                    'name'=>'Hosaena',
                    'name_lan'=>'ሆሳና',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Hosaena',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Dilla')->exists()){
                City::create([
                    'name'=>'Dilla',
                    'name_lan'=>'ዲላ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Dilla',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Areka')->exists()){
                City::create([
                    'name'=>'Areka',
                    'name_lan'=>'አረካ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Areka',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Yirgalem')->exists()){
                City::create([
                    'name'=>'Yirgalem',
                    'name_lan'=>'ይርጋለም',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Yirgalem',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Woliso')->exists()){
                City::create([
                    'name'=>'Woliso',
                    'name_lan'=>'ዎሊሶ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Woliso',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Welkitie')->exists()){
                City::create([
                    'name'=>'Welkitie',
                    'name_lan'=>'ወልቃይት',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Welkitie',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Alaba Kulito')->exists()){
                City::create([
                    'name'=>'Alaba Kulito',
                    'name_lan'=>'አላባ ቁሊቶ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Alaba Kulito',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Durame')->exists()){
                City::create([
                    'name'=>'Durame',
                    'name_lan'=>'ዱራሜ',
                    'region_id'=>$regionSNNP_id,
                    'description' => 'This is the description about Durame',
                    'description_lan' => ''
                ]);
            }
        }

        $regionDR = Region::where('name','Dire Dawa')->first();
        $regionDR_id =$regionDR->id;
        if($regionDR_id != null)
        {
            if (!City::where('name', 'Dire Dawa')->exists()) {
                City::create([
                    'name' => 'Dire Dawa',
                    'name_lan' => 'ድሬ ዳዋ',
                    'region_id' => $regionDR_id,
                    'description' => 'This is the description about Dire Dawa',
                    'description_lan' => ''
                ]);
            }
        }

        $regionAM = Region::where('name', 'Amhara')->first();
        $regionAM_id = $regionAM->id;
        if ($regionAM_id != null)
        {
            if(!City::where('name', 'Finote Selam')->exists()){
                City::create([
                    'name'=>'Finote Selam',
                    'name_lan'=>'ፍኖተ ሰላም',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Finote Selam',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Kobo')->exists()){
                City::create([
                    'name'=>'Kobo',
                    'name_lan'=>'ቆቦ',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Kobo',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Dangila')->exists()){
                City::create([
                    'name'=>'Dangila',
                    'name_lan'=>'ዳንግላ',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Dangila',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Mota')->exists()){
                City::create([
                    'name'=>'Mota',
                    'name_lan'=>'ሞታ',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Mota',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Bahir Dar')->exists()) {

                City::create([
                    'name' => 'Bahir Dar',
                    'name_lan' => 'ባህር ዳር',
                    'region_id' => $regionAM_id,
                    'description' => 'This is the description about Bahir Dar',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Dessie')->exists()) {
                    City::create([
                        'name' => 'Dessie',
                        'name_lan' => 'ደሴ',
                        'region_id' => $regionAM_id,
                        'description' => 'This is the description about Dessie',
                    'description_lan' => ''
                ]);
                }
            if(!City::where('name', 'Debre Birhan')->exists()){
                City::create([
                    'name'=>'Debre Birhan',
                    'name_lan'=>'ደብረ ብርሃን',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Debre Birhan',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Kombolcha')->exists()){
                City::create([
                    'name'=>'Kombolcha',
                    'name_lan'=>'ኮምቦልቻ',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Kombolcha',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Debre Tabor')->exists()){
                City::create([
                    'name'=>'Debre Tabor',
                    'name_lan'=>'ደብረ ታቡር',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Debre Tabor',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Weldiya')->exists()){
                City::create([
                    'name'=>'Weldiya',
                    'name_lan'=>'ወልዲያ',
                    'region_id'=>$regionAM_id,
                    'description' => 'This is the description about Weldiya',
                    'description_lan' => ''
                ]);
            }
            if (!City::where('name', 'Gondar')->exists()) {
                City::create([
                    'name' => 'Gondar',
                    'name_lan' => 'ጎንደር',
                    'region_id' => $regionAM_id,
                    'description' => 'This is the description about Gondar',
                    'description_lan' => ''
                ]);
            }
        }

        $regionSO = Region::where('name', 'Somali')->first();
        $regionSO_id = $regionSO->id;
        if ($regionSO_id != null)
        {
            if(!City::where('name', 'Degahabur')->exists()){
                City::create([
                    'name'=>'Degahabur',
                    'name_lan'=>'ደጋህቡር',
                    'region_id'=>$regionSO_id,
                    'description' => 'This is the description about Degahabur',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Jijiga')->exists()){
                City::create([
                    'name'=>'Jijiga',
                    'name_lan'=>'ጂጂጋ',
                    'region_id'=>$regionSO_id,
                    'description' => 'This is the description about Jijiga',
                    'description_lan' => ''
                ]);
            }
            if(!City::where('name', 'Gode')->exists()){
                City::create([
                    'name'=>'Gode',
                    'name_lan'=>'ጎዴ',
                    'region_id'=>$regionSO_id,
                    'description' => 'This is the description about Gode',
                    'description_lan' => ''
                ]);
            }
        }

        $regionHAR = Region::where('name', 'Harari')->first();
        $regionHAR_id = $regionHAR->id;
        if ($regionHAR_id != null)
        {
            if (!City::where('name', 'Harar')->exists()) {
                City::create([
                    'name' => 'Harar',
                    'name_lan' => 'ሃረር',
                    'region_id' => $regionHAR_id,
                    'description' => 'This is the description about Harar',
                    'description_lan' => ''
                ]);
            }
        }

        $regionGA = Region::where('name', 'Gambela')->first();
        $regionGA_id = $regionGA->id;
        if ($regionGA_id != null)
        {
            if (!City::where('name', 'Gambela')->exists()) {
                City::create([
                    'name' => 'Gambela',
                    'name_lan' => 'ጋምቤላ',
                    'region_id' => $regionGA_id,
                    'description' => 'This is the description about Gambela',
                    'description_lan' => ''
                ]);
            }
        }

        $regionB = Region::where('name', 'Benishangul-Gumuz')->first();
        $regionB_id = $regionB->id;
        if ($regionB_id != null)
        {
            if (!City::where('name', 'Assosa')->exists()) {
                City::create([
                    'name' => 'Assosa',
                    'name_lan' => 'አሶሳ',
                    'region_id' => $regionB_id,
                    'description' => 'This is the description about Assosa',
                    'description_lan' => ''
                ]);
            }
        }

        $regionAF = Region::where('name', 'Afar')->first();
        $regionAF_id = $regionAF->id;
        if ($regionAF_id != null)
        {
            if (!City::where('name', 'Asaita')->exists()) {
                City::create([
                    'name' => 'Asaita',
                    'name_lan' => 'አሳይታ',
                    'region_id' => $regionAF_id,
                    'description' => 'This is the description about Asaita',
                    'description_lan' => ''
                ]);
            }
        }

    }
}
