<?php

namespace App\Http\Controllers;

use App\Models\Survivor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function infected()
    {
        $survivor = Survivor::get();
        $count_survivor = $survivor->count();
        $infected = $survivor->where('is_infected', true)->count();
        $result = ($infected / $count_survivor) * 100;
        return sendResponse("{$result}%", 'success');
    }

    public function non_infected()
    {
        $survivor = Survivor::get();
        $count_survivor = $survivor->count();
        $non_infected = $survivor->where('is_infected', false)->count();
        $result = ($non_infected / $count_survivor) * 100;
        return sendResponse("{$result}%", 'success');
    }

    public function avg_resource()
    {
        return sendResponse(collect(DB::select('SELECT items.item as item_name, avg(amount) FROM survivor_inventories join items on survivor_inventories.item_id = items.id GROUP BY items.item')), 'average item per survivor');
    }
}
