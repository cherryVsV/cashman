<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['title'=>'бульвар Шевченко'],
            ['title'=>'улица Артёма'],
            ['title'=>'Ленинский проспект'],
            ['title'=>'проспект Германа Титова'],
            ['title'=>'бульвар Пушкина'],
            ['title'=>'улица Гёте'],
            ['title'=>'проспект Богдана-Хмельницкого'],
            ['title'=>'улица Университетская'],
            ['title'=>'проспект Германа Титова']


        ];
        foreach($regions as $region)
            Region::create([
                'title'=>$region['title']
            ]);
    }
}
