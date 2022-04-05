<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'item' => 'Water',
                'points' => 4
            ],
            [
                'item' => 'Food',
                'points' => 3
            ],
            [
                'item' => 'Medication',
                'points' => 2
            ],
            [
                'item' => 'Ammunition',
                'points' => 1
            ]
        ];
        Item::insert($items);
    }
}
