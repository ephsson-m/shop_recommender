<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopToUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Client as Mongo;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /*public function store(StoreUserRequest $request)
    {

        $user = User::create($request->validated());
        return UserResource::make($user);
        
    }*/
    public function store(Request $request)
{
    $users = $request->input();
    
    foreach ($users as $userData) {
        User::create($userData);
    }

    return response()->json(['message' => 'Users created successfully.'], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }


    public function buyItem(Request $request, User $user, Shop $shop)
    {
        //POST Request ile satın alınacak item id'sini gir

        $boughtItemId = $request->input('item_id');

        //Bilgileri Pivot Table'lara kaydet

        $user->items()->attach($boughtItemId);
        $shop->items()->attach($boughtItemId);
        $user->shops()->attach($shop->id);

        //MongoDB'ye kaydetmek için SQL'den gerekli bilgileri fetchle

        $itemData = DB::table('items')->where('id', $boughtItemId)->first();
        if (!$itemData) {
            return response()->json(['message' => 'item verisi bulunamadi'], 404);
        }
        $shopData = DB::table('shops')->where('id', $shop->id)->first();
        if (!$shopData) {
            return response()->json(['message' => 'shop verisi bulunamadi'], 404);
        }
        $userData = DB::table('users')->where('id', $user->id)->first();
        if (!$userData) {
            return response()->json(['message' => 'user verisi bulunamadi'], 404);
        }                                                                                   

        //UserLog BSON Objesi oluştur
        $mongo = new Mongo;
        $collection = $mongo->shop_recommender->user_logs;
        $collection2 = $mongo->shop_recommender->shop_logs;

        $userLog = [
            'user_id' => $user->id,
            'shop' => [
                'shop_id' => $shopData->id,
                'shop_brand' => $shopData->brand,
                'shop_category' => $shopData->category,
                'shop_city' => $shopData->city,
                'shop_district' => $shopData->district,
                'shop_location_type' => $shopData->location_type,
                'shop_customer_capacity' => $shopData->customer_capacity,
                'shop_number_of_staff' => $shopData->number_of_staff,
            ],
            'item' => [
                'item_id' => $itemData->id,
                'item_name' => $itemData->name,
                'item_general_category' => $itemData->general_category,
                'item_sub_category' => $itemData->sub_category
            ],
        ];
        $collection->insertOne($userLog);

        $shopLog = $collection2->findOne(['shop_id' => $shopData->id, 'item_id' => $itemData->id]);
        if($shopLog) {
            $collection2->updateOne(
                ['_id' => $shopLog->_id],
                ['$inc' => ['item_sold_count' => 1]]
            );
        }   else {
            $collection2->insertOne([
                'shop_id' => $shopData->id,
                'item_id' => $itemData->id,
                'item_sold_count' => 1
            ]);
        }
    
        return response()->json(['message' => 'Log entry successful.'], 200);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
