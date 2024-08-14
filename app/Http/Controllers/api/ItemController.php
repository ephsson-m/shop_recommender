<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;

class ItemController extends Controller
{

    public function index()
    {

        return ItemResource::collection(Item::all());

    }

   /* public function store(StoreItemRequest $request)
    {

        $item = Item::create($request->validated());
        return ItemResource::make($item);

    }*/

    public function storeMultipleItems(HttpRequest $request)
{
    $items = $request->input();
    
    foreach ($items as $itemData) {
        Item::create($itemData);
    }

    return response()->json(['message' => 'Items created successfully.'], 201);
}

}



