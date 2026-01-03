<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Hardware',
                'slug' => 'hardware'
            ],
            [
                'name' => 'Software',
                'slug' => 'software'
            ],
            [
                'name' => 'Network',
                'slug' => 'network'
            ],
            [
                'name' => 'Access',
                'slug' => 'access'
                ]
        ]);
    }
}
