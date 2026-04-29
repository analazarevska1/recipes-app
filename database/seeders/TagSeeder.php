<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ["Breakfast","Lunch","Dinner","Snack","Dessert","Sweet","Savory","Under 20 min","Vegetarian","Vegan","Gluten-Free","Easy"];

        foreach($tags as $tag){
            DB::table('tags')->insert(['name'=>$tag]);
        }

   
    }
}
