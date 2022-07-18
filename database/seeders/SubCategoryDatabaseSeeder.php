<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Category::factory()
            ->count(10)

            ->create(['parent_id'=>$this->getRandomValue()]);
    }
    private function getRandomValue()
    {
        $parent_id =  \App\Models\Category::inRandomOrder()->first();
        return $parent_id;

        }
}
