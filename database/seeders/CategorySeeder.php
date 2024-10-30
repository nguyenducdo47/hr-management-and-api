<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
            'slug'=>'electronics',
        ]);
        Category::create([
            'name' => 'Fashion',
            'slug'=>'fashion',
        ]);
    }
}
