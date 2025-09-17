<?php

// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder {
    public function run(): void {
        foreach ([
            'Catering',
            'Decoration',
            'Photography',
            'Videography',
            'Music / DJ',
            'Live Band',
            'MC / Host',
            'Venue',
            'Lighting & Sound',
            'Event Planning & Coordination',
            'Security Services',
            'Florist',
            'Cake & Desserts',
            'Beverages & Bartending',
            'Makeup & Hair Styling',
            'Fashion & Attire',
            'Transport / Chauffeur',
            'Car Rental & Limousine',
            'Stage & Setup',
            'Invitations & Printing',
            'Gifts & Souvenirs',
            'Kids Entertainment',
            'Photo Booth',
            'Furniture & Rentals',
            'Tents & Canopies',
            'Cleaning Services',
            'Traditional / Cultural Performers',
            'Event Technology (Screens, Projectors)',
            'Event Insurance',
        ] as $category) {
            DB::table('categories')->updateOrInsert(
                ['name' => $category], // check for duplicate
                ['name' => $category]  // if not, insert
            );
        }
        
    }
}

