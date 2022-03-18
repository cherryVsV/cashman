<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        $this->call(CategoriesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(GroupCompaniesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $number = 0;
        while($number<6) {
            $this->call(CompanyAdvertisingTableSeeder::class);
            $number++;
        }

        Model::reguard();
    }
}
