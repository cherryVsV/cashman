<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            ['title'=>'Кофейни'],
            ['title'=>'Cуши-бары'],
            ['title'=>'Кафе и рестораны'],
            ['title'=>'Спорт'],
            ['title'=>'Магазины'],
            ['title'=>'Активный отдых'],
            ['title'=>'Сувениры'],
        ];
        foreach($categories as $category)
            Category::create([
                'title'=>$category['title']
            ]);

    }
}
