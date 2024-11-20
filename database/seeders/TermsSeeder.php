<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = [
            'example.com',
            'blog.example.com',
            'shop.example.com',
            'news.example.com',
        ];

        foreach ($terms as $term) {
            DB::table('terms')->insert([
                'utm_term' => $term,
                'name' => fake()->words(4, true),
            ]);
        }
    }
}
