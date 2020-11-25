<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = collect([
            'Y7', 'Y8', 'Y9', 'Y10', 'Y11', 'Y12', 'Staff'
        ])->map(function ($value) {
            return ['name' => $value];
        })->toArray();

        Category::insert($categories);
    }
}
