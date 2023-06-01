<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Category::truncate();


        DB::table('categories')->insert([
            'category' => 'Clothes',
            
        ]);

        DB::table('categories')->insert([
            'category' => 'Furniture',
            
        ]);

        DB::table('categories')->insert([
            'category' => 'Stationery',
            
        ]);

        DB::table('categories')->insert([
            'category' => 'Devices',
            
        ]);

        DB::table('categories')->insert([
            'category' => 'toys',
            
        ]);

        
    }
}
