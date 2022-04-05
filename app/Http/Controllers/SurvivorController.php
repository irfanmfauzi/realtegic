<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurvivorStoreRequest;
use App\Http\Requests\SurvivorTradeRequest;
use App\Http\Requests\SurvivorUpdateInfectedRequest;
use App\Http\Requests\SurvivorUpdateLocationRequest;
use App\Http\Requests\SurvivorUpdateRequest;
use App\Models\Item;
use App\Models\Survivor;
use App\Models\SurvivorInventory;

class SurvivorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Survivor::with('SurvivorInventory')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SurvivorStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurvivorStoreRequest $request)
    {
        $dto = $request->validated();
        $now = now();
        $survivor = Survivor::create([
            'name' => $dto['name'],
            'age' => $dto['age'],
            'gender' => $dto['gender'],
        ]);
        foreach ($dto['initial_item'] as $index => $value) {
            $dto['initial_item'][$index]['survivor_id'] = $survivor->id;
            $dto['initial_item'][$index]['created_at'] = $now;
            $dto['initial_item'][$index]['updated_at'] = $now;
        }

        SurvivorInventory::insert($dto['initial_item']);

        return sendSuccess('Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Survivor::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SurvivorUpdateRequest $request, $id)
    {
        $survivor = Survivor::findOrFail($id);
        $survivor->update($request->validated());

        return sendSuccess('success');
    }

    public function update_location(SurvivorUpdateLocationRequest $request, $id)
    {
        $survivor = Survivor::findOrFail($id);
        $survivor->update(['last_location' => implode(',', $request->validated())]);
        return sendSuccess('success');
    }

    public function update_infected(SurvivorUpdateInfectedRequest $request, $id)
    {
        $dto = $request->validated();
        $survivor = Survivor::findOrFail($id);
        $survivor->update(['is_infected' => $dto['is_infected']]);

        return sendSuccess('success');
    }

    public function trade(SurvivorTradeRequest $request)
    {
        $dto = $request->validated();
        $survivor1 = Survivor::findOrFail($dto['survivor_id_1']);
        $survivor2 = Survivor::findOrFail($dto['survivor_id_2']);

        if ($survivor1->is_infected == true or $survivor2->is_infected == true) {
            return sendError('Infected survivor cant trade');
        }

        foreach ($dto['survivor1_item'] as $index => $value) {
            $dto['survivor1_item'][$index]['points'] = Item::findOrFail($value['item_id'])->points * $value['amount'];
        }

        foreach ($dto['survivor2_item'] as $index => $value) {
            $dto['survivor2_item'][$index]['points'] = Item::findOrFail($value['item_id'])->points * $value['amount'];
        }

        if (array_sum(array_column($dto['survivor1_item'], 'points')) == array_sum(array_column($dto['survivor2_item'], 'points'))) {
            foreach ($dto['survivor1_item'] as $value) {
                SurvivorInventory::updateOrCreate(
                    [
                        'survivor_id' => $dto['survivor_id_1'],
                        'item_id' => $value['item_id']
                    ],
                    [
                        'amount' => SurvivorInventory::where('survivor_id', $dto['survivor_id_1'])->where('item_id', $value['item_id'])->first()->amount - $value['amount']
                    ]
                );

                SurvivorInventory::updateOrCreate(
                    [
                        'survivor_id' => $dto['survivor_id_2'],
                        'item_id' => $value['item_id']
                    ],
                    [
                        'amount' => SurvivorInventory::where('survivor_id', $dto['survivor_id_2'])->where('item_id', $value['item_id'])->first()->amount + $value['amount']
                    ]
                );
            }
            foreach ($dto['survivor2_item'] as $value) {
                SurvivorInventory::updateOrCreate(
                    [
                        'survivor_id' => $dto['survivor_id_1'],
                        'item_id' => $value['item_id']
                    ],
                    [
                        'amount' => SurvivorInventory::where('survivor_id', $dto['survivor_id_1'])->where('item_id', $value['item_id'])->first()->amount - $value['amount']
                    ]
                );

                SurvivorInventory::updateOrCreate(
                    [
                        'survivor_id' => $dto['survivor_id_2'],
                        'item_id' => $value['item_id']
                    ],
                    [
                        'amount' => SurvivorInventory::where('survivor_id', $dto['survivor_id_2'])->where('item_id', $value['item_id'])->first()->amount + $value['amount']
                    ]
                );
            }
        } else {
            return sendError('Trade not worth it');
        }

        return sendSuccess('success');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survivor = Survivor::findOrFail($id);
        $survivor->delete();
        return sendSuccess('success');
    }
}
