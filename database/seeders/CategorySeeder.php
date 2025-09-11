<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Home',
                'slug' => 'home',
                'description' => 'Homepage and main landing pages',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'About',
                'slug' => 'about',
                'description' => 'About us and company information',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'description' => 'Service offerings and solutions',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Products',
                'slug' => 'products',
                'description' => 'Product catalog and information',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Blog',
                'slug' => 'blog',
                'description' => 'Blog posts and articles',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'description' => 'Contact pages and forms',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
