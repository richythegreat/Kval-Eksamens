<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() === 0) {
            $users = User::factory(5)->create();
        }

        Item::factory(20)->create([
            'user_id' => $users->random()->id,
        ]);

        //LOST items
        Item::create([
            'title' => 'Lost Black Wallet',
            'description' => 'Black leather wallet lost near the central bus station.',
            'category' => 'Personal Items',
            'status' => 'lost',
            'city' => 'Rīga',
            'user_id' => $users->random()->id,
        ]);

        Item::create([
            'title' => 'Lost Golden Ring',
            'description' => 'Wedding ring with initials M.K. Lost on the beach.',
            'category' => 'Jewelry',
            'status' => 'lost',
            'city' => 'Jūrmala',
            'user_id' => $users->random()->id,
        ]);

        //FOUND items
        Item::create([
            'title' => 'Found Phone',
            'description' => 'Found a Samsung smartphone near a park bench.',
            'category' => 'Electronics',
            'status' => 'found',
            'city' => 'Rīga',
            'user_id' => $users->random()->id,
        ]);

        Item::create([
            'title' => 'Found Backpack',
            'description' => 'Blue backpack found at a bus stop.',
            'category' => 'Bags',
            'status' => 'found',
            'city' => 'Liepāja',
            'user_id' => $users->random()->id,
        ]);
    }
}
