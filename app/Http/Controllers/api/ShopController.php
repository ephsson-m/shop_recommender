<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemToShopRequest;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ShopResource::collection(Shop::all());
    }

 
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopRequest $request)
    {
        $shop = Shop::create($request->validated());
        return ShopResource::make($shop);
    }

    public function storeMultipleShops(Request $request)
{
    $shops = $request->input();
    
    foreach ($shops as $shopData) {
        Shop::create($shopData);
    }

    return response()->json(['message' => 'Shops created successfully.'], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        return ShopResource::make($shop);
    }

    /**
     * Show the form for editing the specified resource.
     */
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
