<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ]
        );

        // Create regular user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'role' => 'user',
            ]
        );

        // Sample categories and products
        $cats = [
            ['name' => 'Fastening & Joining', 'description' => 'Fasteners and joining products'],
            ['name' => 'Adhesives & Tape', 'description' => 'Adhesives and tapes'],
            ['name' => 'Welding', 'description' => 'Welding and brazing supplies'],
        ];

        foreach ($cats as $c) {
            $category = \App\Models\Category::updateOrCreate(
                ['slug' => \Str::slug($c['name'])],
                [
                    'name' => $c['name'],
                    'description' => $c['description'],
                ]
            );

            // Only create products if they don't exist
            if ($category->products()->count() === 0) {
                for ($i = 1; $i <= 3; $i++) {
                    \App\Models\Product::create([
                        'category_id' => $category->id,
                        'name' => $category->name . ' Product ' . $i,
                        'sku' => strtoupper(substr($category->name,0,3)) . '-' . $i,
                        'description' => 'Sample product ' . $i,
                        'price' => rand(100, 1000) / 10,
                        'image_url' => 'https://placehold.co/150'
                    ]);
                }
            }
        }
    }
}
