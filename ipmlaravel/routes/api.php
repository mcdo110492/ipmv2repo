<?php

use Illuminate\Http\Request;



Route::post('authenticate', 'AuthenticateController@authenticate');

Route::get('authenticate','AuthenticateController@checkValidity');



Route::group(['middleware' => 'jwt.auth'], function()
{
  // ITEM TYPES
   Route::get('item/type','ItemTypeController@index');

   Route::get('item/type/show','ItemTypeController@show');

   Route::post('item/type/check','ItemTypeController@check');

   Route::post('item/type', 'ItemTypeController@store');

   Route::put('item/type/{type}', 'ItemTypeController@update');

   // ITEM STATUS
   Route::get('item/status','ItemStatusController@index');

   Route::post('item/status/check','ItemStatusController@check');

   Route::post('item/status', 'ItemStatusController@store');

   Route::put('item/status/{id}', 'ItemStatusController@update');

   Route::get('item/status/show','ItemStatusController@show');

   // ITEM

   Route::get('item','ItemController@index');

   //Route::post('item/check','ItemController@check');

   Route::post('item', 'ItemController@store');

   Route::put('item/{id}', 'ItemController@update');

   Route::get('item/show','ItemController@show');

   //ITEM INVENTORY
   
   Route::get('item/inventory','ItemInventoryController@index');

   Route::post('item/inventory','ItemInventoryController@store');

   Route::put('item/inventory/{id}', 'ItemInventoryController@update');

    
});