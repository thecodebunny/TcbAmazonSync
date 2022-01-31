<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'tcb-amazon-sync' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('tcb-amazon-sync', function () {

    //Marektplace routes
    Route::get('/amazon/{item_id}', 'Amazon\Main@asinform')->name('amazon.asinsetup');
    Route::get('/amazon-dashboard', 'Amazon\Main@dashboard')->name('amazon.dashboard');

    //Warehouse Routes
    Route::get('/amazon-warehouses', 'Warehouse@index')->name('amazon.warehouses');
    Route::get('/amazon-warehouses/create', 'Warehouse@create')->name('amazon.warehouses.create');
    Route::post('/amazon-warehouses/save', 'Warehouse@save')->name('amazon.warehouse.save');
    Route::get('/amazon-warehouses/edit/{id}', 'Warehouse@edit')->name('amazon.warehouse.edit');
    Route::post('/amazon-warehouses/update/{id}', 'Warehouse@update')->name('amazon.warehouse.update');
    Route::post('/amazon-warehouses/destroy/{id}', 'Warehouse@destroy')->name('amazon.warehouse.destroy');
    Route::get('/amazon-warehouses/duplicate/{id}', 'Warehouse@duplicate')->name('amazon.warehouse.duplicate');

    //Menu Routes
    Route::get('/amazon-settings', 'Amazon\Settings@settings')->name('amazon.settings');
    Route::post('/amazon-settings/update', 'Amazon\Settings@update')->name('amazon.settings.update');
    Route::get('/amazon-categories', 'Amazon\Categories@list')->name('amazon.categories');
    Route::get('/amazon-items', 'Amazon\Main@items')->name('amazon.items');
    Route::get('/amazon-items-index/{country}', 'Amazon\Items@index')->name('amazon.items.index');

    //Amazon Item Routes
    Route::post('/amazon-items/item/create', 'Amazon\Items@createItem')->name('items.create');
    Route::post('/amazon-items/item/update/{id}', 'Amazon\Items@updateItem')->name('items.update');
    Route::get('/amazon-items/item/show/{id}/{country}', 'Amazon\Items@showItem')->name('items.show');
    Route::post('/items/create', 'Amazon\Items@create')->name('items.index');

    //Amazon Order Routes
    Route::get('/amazon-orders', 'Amazon\Orders@index')->name('amazon.orders.index');
    Route::get('/amazon-orders/{id}', 'Amazon\Orders@show')->name('amazon.orders.show');
    Route::get('/amazon-ordersitems-update/{country}', 'Amazon\Orders@toRemove')->name('amazon.orders.itemsupdate');

    //Amazon API Settings
    Route::get('/amazon-sp-settings', 'Amazon\Settings@spapisettings')->name('amazon.spapisettings');
    Route::get('/amazon-mws-settings', 'Amazon\Settings@mwsapisettings')->name('amazon.mwsapisettings');
    Route::get('/amazon-pa-settings', 'Amazon\Settings@paapisettings')->name('amazon.paapisettings');
    Route::post('/amazon-settings/spapi/update', 'Amazon\Settings@updateSpApiSettings')->name('amazon.apisettings.updatesp');
    Route::post('/amazon-settings/paapi/update', 'Amazon\Settings@updatePaApiSettings')->name('amazon.apisettings.updatepa');
    Route::post('/amazon-settings/mwsapi/update', 'Amazon\Settings@updateMwsApiSettings')->name('amazon.apisettings.updatemws');

    //SP API Routes
        //Product Item APIs
        Route::get('/amazon-fetchSpProducts/{country}', 'Amazon\SpApi@getAllItems')->name('amazon.spitems');
        Route::get('/amazon/item/get/{id}/{country}', 'Amazon\SpApi@getItem')->name('amazon.item.get');
        Route::get('/amazon-patchstock/{country}/{sku}/{qty}', 'Amazon\SpApi@updateAmazonItemStock')->name('amazon.patchstock');
        Route::get('/amazon-getAplus/{country}', 'Amazon\SpApi@getAplusContents')->name('amazon.aplus');
        Route::get('/amazon-updateitem-onamazon/{country}/{id}', 'Amazon\SpApi@updateItemOnAmazon')->name('amazon.updateItemOnAmz');

        //Product Attributes APIs
        Route::get('/amazon-updatestock/{country}/{id}/{qty}', 'Amazon\SpApi@updateAmazonItemStock')->name('amazon.updateStock');
        Route::get('/amazon-updatetitle/{country}/{id}/{title}', 'Amazon\SpApi@updateAmazonItemTitle')->name('amazon.updateTitle');
        Route::get('/amazon-updateprice/{country}/{id}/{price}/{currency}', 'Amazon\SpApi@updateAmazonItemPrice')->name('amazon.updatePrice');
        Route::get('/amazon-updatesaleprice/{country}/{id}/{startdate}/{enddate}/{saleprice}/{currency}', 'Amazon\SpApi@updateAmazonSalePrice')->name('amazon.updateSalePrice');

        //Orders APIs
        Route::get('/amazon-getOrderAddress/{orderid}/{country}', 'Amazon\SpApi@getOrderAddress')->name('amazon.getOrderAddress');

        //Feeds APIs
        Route::get('/amazon-getfeed/{feedid}/{country}', 'Amazon\Feeds\Inventory@getFeed')->name('amazon.getFeed');
        Route::get('/amazon-getfeed/{feedid}/{country}', 'Amazon\Feeds\Inventory@getFeed')->name('amazon.getFeed');

    //Amazon Other API Routes
    Route::get('/amazon-fetchAllProducts/{country}', 'Amazon\MwsApi@fetchAllProducts')->name('amazon.mwstest');
    Route::get('/amazon-fetchPaProducts/{country}', 'Amazon\PaApi@fetchAllProducts')->name('amazon.patest');
    Route::get('/amazon/mwsapi/fetch/{item_id}/{ean}/{country}', 'Amazon\MwsApi@fetchAmazonItem')->name('amazon.item.fetch');
    Route::get('/amazon-getorders/{country}', 'Amazon\Orders@getOrders')->name('amazon.getOrders');

});
