<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(20)->create()->each(function($book){
            $numberReview = random_int(5,30);
            Review::factory()->count($numberReview)->god()->for($book)->create();
        });
        
        Book::factory(46)->create()->each(function($book){
            $numberReview = random_int(5,30);
            Review::factory()->count($numberReview)->average()->for($book)->create();
        });
        
        Book::factory(34)->create()->each(function($book){
            $numberReview = random_int(5,30);
            Review::factory()->count($numberReview)->bad()->for($book)->create();
        });
    }
}
