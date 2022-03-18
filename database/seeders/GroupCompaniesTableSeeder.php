<?php

namespace Database\Seeders;

use App\Models\GroupCompany;
use Illuminate\Database\Seeder;

class GroupCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $groups = [
            [
                'image'=>'categories/category-coffee.png', 'title'=>'Кофейни',
                'description'=>'Самое лучшее кофе в ближайшем для Вас месте!', 'position'=>'coffee'
            ],
            [
                'image'=>'categories/category-sushi.jpg', 'title'=>'Суши-бары',
                'description'=>'Самые лучшие суши-бары в шаговой доступности для Вас!', 'position'=>'sushi'
            ],
            [
                'image'=>'categories/category-cafe.png', 'title'=>'Кафе и рестораны',
                'description'=>'Самые лучшие кафе и рестораны в шаговой доступности для Вас!', 'position'=>'cafe'
            ],
            [
                'image'=>'categories/category-sport.png', 'title'=>'Спорт',
                'description'=>'Самый лучшие спортзалы в ближайшем для Вас месте!', 'position'=>'sport'
            ],
            [
                'image'=>'categories/category-shop.png', 'title'=>'Магазины',
                'description'=>'Самый лучшие и выгодные магазины в ближайшем для Вас месте!', 'position'=>'shop'
            ],
            [
                'image'=>'categories/category-active-rest.png', 'title'=>'Активный отдых',
                'description'=>'Проведи яркие выходные вместе с нами!', 'position'=>'active-rest'
            ],
            [
                'image'=>'categories/category-souvenir.png', 'title'=>'Сувениры',
                'description'=>'Самые оригинальные и приятные подарки для Вас и Ваших близких!', 'position'=>'souvenir'
            ],
        ];
        foreach ($groups as $group)
            GroupCompany::create([
                'image'=>$group['image'],
                'title'=>$group['title'],
                'description'=>$group['description'],
                'position'=>$group['position']
                ]);
    }
}
