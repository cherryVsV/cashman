<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;



class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $companies = [
            [
                'title' => 'AR COFFEE', 'domain' => 'arcoffee_dn_bot', 'cashback_percent' => 7, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Вкусный кофе в центре Донецка! У нас вы можете купить много сортов натурального кофе вместе с нашей фирменной выпечкой!',
                'image' => 'companyLogos/arcoffee.jpg', 'latitude'=>48.008579, 'longitude'=> 37.810202,
                'company_group_id' => 1, 'properties' => [ 'time' => '8.00-21.00', 'address' => 'Бульвар Шевченко, 13'],
                'socials' => ['instagram' => 'https://www.instagram.com/arcoffee_dn/', 'telegram' => 'https://t.me/arcoffee_dn_bot/', 'vk'=>null, 'facebook'=>null], 'callback_url' => 'https://t.me/arcoffee_dn_bot/',
                'is_active' => true, 'upload_vk_url' => '', 'creator_id' => 1],
            [
                'title' => 'ISUSHI', 'domain' => 'isushi-dn.ru', 'cashback_percent' => 10, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'BURGERS&ISUSHI - это объединение самых популярных кухонь. Благодаря этому мы предоставляем самый широкий ассортимент направлений - wok, суши и роллы, сочные бургеры, пиццы на тонком и на толстом тесте, закуски и обеды. Уникальные авторские рецепты, классические блюда, множество скидок и акций, система кешбека - все это делает нас теми, кто мы есть. Для нас важен каждый гость, именно поэтому мы так ценим качество!',
                'image' => 'companyLogos/isushi.jpg', 'latitude'=>48.013024, 'longitude'=> 37.803327,
                'company_group_id' => 2, 'properties' => [ 'time' => '10.00-22.00', 'address' => 'Ул. Артёма,133б, ТЦ Форум'], 'socials' => ['instagram' => 'https://www.instagram.com/burgers_isushi_dn/', 'telegram' => 'https://t.me/diner_dn_bot', 'vk' => 'https://vk.com/burgers_isushi_dn', 'facebook'=>null],
                'callback_url' => 'https://t.me/arcoffee_dn_bot/',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/burgers_isushi_dn', 'creator_id' => 1
            ],
            [
                'title' => 'BAR BOSKO', 'domain' => 'barbosko_bot', 'cashback_percent' => 10, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Ресторан БарБоско - это душевная обстановка, сытная домашняя кухня и необычные согревающие напитки.Когда мы говорим о настоящей кухне, то всегда подразумеваем с детства знакомые домашние мотивы, которые из поколения в поколение передаются и бережно сохраняются. И как же здорово, что в Республике все больше таких мест. Ресторан домашней кухни «БарБоско» поражает своей фирменной начинкой. Пожалуй, это самый уникальный рестораны в столице, где как на международном музыкальном фестивале, бок о бок, в дружеской и гостеприимной атмосфере, стоят стили разных кухонь. Невероятная задача стоявшая перед рестораторами, объединить блюда разных стран выполнена на отлично!',
                'image' => 'companyLogos/barbosko.jpg', 'latitude'=>47.986519,'longitude'=> 37.786077,
                'company_group_id' => 3, 'properties' => ['time' => '10.00-22.00','address' => 'Ленинский проспект, 11б'], 'socials' => ['instagram' => 'https://www.instagram.com/bar.bosco.cafe/', 'telegram' => 'https://t.me/barbosko_bot', 'vk' => 'https://vk.com/barbosko_donetsk', 'facebook'=>null],
                'callback_url' => 'https://vk.com/barbosko_donetsk',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/barbosko_donetsk', 'creator_id' => 1
            ],
            [
                'title' => 'BODY MASTER', 'domain' => 'bodymaster.ru', 'cashback_percent' => 10, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'BODY MASTER - территория красивого и здорового тела, хорошего настроения и заряда энергией⚡️',
                'image' => 'companyLogos/bodymaster.jpg', 'latitude'=>48.022055,'longitude'=> 37.803578,
                'company_group_id' => 4, 'properties' => ['time' => 'ПН-ПТ 8:00-21:00 СБ-ВС 9:00-19:00', 'address' => 'г. Донецк, пр-кт Германа Титова 9'],
                'socials' => ['instagram' => 'https://www.instagram.com/bodymaster_dn/', 'telegram' => 'https://t.me/body_master_bot/', 'vk' => 'https://vk.com/club46584117', 'facebook'=>null], 'callback_url' => 'https://bodymaster.ru',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/club46584117', 'creator_id' => 1
            ],
            [
                'title' => 'BURGER BAR', 'domain' => 'burgerbardonetsk.com', 'cashback_percent' => 7, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Burger Bar Донецк, бул. Пушкина, 28 +38 (066) 177-51-88 +38 (071) 327-77-20',
                'image' => 'companyLogos/burgerbar.jpg', 'latitude'=>48.008579, 'longitude'=>37.810202,
                'company_group_id' => 3, 'properties' => ['time' => '8.00-21.00', 'address' => 'Бул. Пушкина, 28'], 'socials' => ['instagram' => 'https://www.instagram.com/burgerbardonetsk/', 'telegram' => 'https://t.me/burgerbardonetsk_bot/', 'vk' => 'https://vk.com/burgerbardonetsk', 'facebook'=>null],
                'callback_url' => 'https://t.me/burgerbardonetsk_bot/',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/burgerbardonetsk', 'creator_id' => 1
            ],
            [
                'title' => 'Царский', 'domain' => 'carskiy_dn', 'cashback_percent' => 7, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Магазин Царский - это живые раки в Донецке, креветка, махан и другая продукция к пиву для приятного времяпровождения! Мы дорожим своей репутацией и гарантируем, что наши продукты отвечают самым высоким стандартам и достойны самого изысканного вкуса.',
                'image' => 'companyLogos/carskiy.jpg', 'latitude'=>48.003713, 'longitude'=> 37.798700,
                'company_group_id' => 5, 'properties' => ['time' => '10 .00 до 21.00 - без выходных и перерывов', 'address' => 'Ул. Университетская, 20'], 'socials' => ['instagram' => 'https://www.instagram.com/carskiy_dn/', 'telegram' => 'https://t.me/carskiy_dn_bot/', 'facebook'=>null, 'vk'=>null], 'callback_url' => ' https://vk.com/raki_1',
                'is_active' => true, 'upload_vk_url' => ' https://vk.com/raki_1', 'creator_id' => 1
            ],
            [
                'title' => 'Chelentano', 'domain' => 'celentano.dn.ua', 'cashback_percent' => 10, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Кафе «Пицца Челентано»! Вас ждут оригинальный интерьер, внимательный персонал и неизменно позитивная атмосфера 😉👌 Вам предложат блюда только из свежих продуктов, богатые на микроэлементы, витамины и минералы. Паста 🍝, блинчики 🥞, салаты 🥗, суши 🍣 и роллы 🍣, супы 🍲, напитки 🍹🍸🍷, десерты 🍰🍫🍒, настоящий кофе ☕ и конечно же самая вкусная пицца 🍕 в городе! Все блюда созданы, чтобы поразить Ваш вкус!',
                'image' => 'companyLogos/celentano.jpg', 'latitude'=>48.008579, 'longitude'=>37.810202,
                'company_group_id' => 3, 'properties' => ['time' => '10.00-22.00', 'address' => ['пр. Богдана-Хмельницкого 92', 'бул. Шевченко 48', 'ул. Артема 277']],
                'socials' => ['instagram' => 'https://www.instagram.com/chelentanodonetsk/', 'telegram' => 'https://t.me/celentanodon_bot/', 'vk' => 'https://vk.com/celentanodonetsk', 'facebook'=>null], 'callback_url' => 'https://t.me/celentanodon_bot/',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/celentanodonetsk', 'creator_id' => 1
            ],
            [
                'title' => 'Diner', 'domain' => 'diner-dn.ru', 'cashback_percent' => 10, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => '🍔 сочные, аппетитные бургеры 🍝 лапша WOK на любой вкус🍕 ароматная пицца',
                'image' => 'companyLogos/diner.jpg', 'latitude'=>48.007746, 'longitude'=> 37.804889,
                'company_group_id' => 3, 'properties' => ['time' => 'Режим работы: 09:00-22:00', 'address' => 'Артема, 127, Донецк'],
                'socials' => ['instagram' => 'https://www.instagram.com/diner_dn/', 'telegram' => 'https://t.me/diner_dn_bot/', 'vk' => 'https://vk.com/diner_dn', 'facebook'=>null], 'callback_url' => 'https://t.me/diner_dn_bot/',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/diner_dn', 'creator_id' => 1
            ],
            [
                'title' => 'ОСТРОВ Wake Park Donetsk', 'domain' => 'wake_bot', 'cashback_percent' => 7, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Вейк-парк - место для экстремального спорта и семейного отдыха.',
                'image' => 'companyLogos/wakepark.jpg', 'latitude'=>47.985646, 'longitude'=> 37.728848,
                'company_group_id' => 6, 'properties' => ['time' => '10.00-22.00', 'address' => 'ул. Гете, 1в, Донецк'],
                'socials' => ['instagram' => ' https://instagram.com/ostrov.wakeparkdonetsk', 'telegram' => 'https://t.me/wakepark_bot/', 'vk' => 'https://vk.com/ostrov.wakeparkdonetsk', 'facebook'=>null], 'callback_url' => 'https://t.me/wakepark_bot',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/ostrov.wakeparkdonetsk', 'creator_id' => 1
            ],
            [
                'title' => 'Донецкий сувенир', 'domain' => 'shop.advdnr.ru', 'cashback_percent' => 7, 'cashback_percent_level_1' => 3,
                'cashback_percent_level_2' => 1, 'description' => 'Магазин сувениров. Сувенирная продукция. Подарки с символикой. Подарки с гравировкой.Корпоративные подарки. Футболки с печатью. Настольные игры. В нашем магазине представлена продукция для самого разного покупателя - от крупных учреждений и предприятий до коллекционеров и просто жителей, которые смогут теперь в одном месте купить подарки с символикой нашей Республики.
                 У нас вы точно найдете продукцию, которая Вам по душе.',
                'image' => 'companyLogos/souvenir.jpg', 'latitude'=>48.000119, 'longitude'=> 37.801240,
                'company_group_id' => 7, 'properties' => [ 'time' => 'Понедельник - выходной.10.00-19.00', 'address' => 'Бульвар Пушкина, 8'],
                'socials' => ['instagram' => 'https://www.instagram.com/don.suvenir/', 'telegram' => 'https://t.me/souvenir_dn_bot/', 'vk' => 'https://vk.com/don.suvenir', 'facebook'=>null],
                'callback_url' => 'https://vk.com/don.suvenir',
                'is_active' => true, 'upload_vk_url' => 'https://vk.com/don.suvenir', 'creator_id' => 1
            ],


        ];
        foreach ($companies as $company)
            Company::create([
                'title' => $company['title'],
                'domain' => $company['domain'],
                'password'=>md5('12345678'),
                'cashback_percent' => $company['cashback_percent'],
                'cashback_percent_level_1' => $company['cashback_percent_level_1'],
                'cashback_percent_level_2' => $company['cashback_percent_level_2'],
                'description' => $company['description'],
                'image' => $company['image'],
                'latitude'=> $company['latitude'],
                'longitude'=>$company['longitude'],
                'company_group_id' => $company['company_group_id'],
                'properties' => [
                    'time'=>$company['properties']['time'],
                    'address'=>$company['properties']['address']
                ],
                'socials' => [
                    'vk'=>$company['socials']['vk'],
                    'telegram'=>$company['socials']['telegram'],
                    'instagram'=>$company['socials']['instagram'],
                    'facebook'=>$company['socials']['facebook']
                ],
                'callback_url' => $company['callback_url'],
                'is_active' => $company['is_active'],
                'upload_vk_url' => $company['upload_vk_url'],
                'creator_id' => $company['creator_id'],
            ]);
    }
}
