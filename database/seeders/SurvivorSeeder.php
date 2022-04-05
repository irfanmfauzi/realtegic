<?php

namespace Database\Seeders;

use App\Models\Survivor;
use App\Models\Item;
use App\Models\SurvivorInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurvivorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survivor1 = Survivor::create([
            'name' => 'Survivor1',
            'age' => 20,
            'gender' => 'Male',
            'last_location' => '-6.958070,107.711498'
        ]);

        foreach (Item::all() as $value) {
            SurvivorInventory::create([
                'survivor_id' => $survivor1->id,
                'item_id' => $value->id,
                'amount' => rand(1, 10)
            ]);
        }
    }
}
