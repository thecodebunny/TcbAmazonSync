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

    //Menu Routes
    Route::get('/amazon-dashboard', 'Amazon\Main@dashboard')->name('amazon.dashboard');
    Route::get('/amazon-settings', 'Amazon\Settings@settings')->name('amazon.settings');
    Route::post('/amazon-settings/update', 'Amazon\Settings@update')->name('amazon.settings.update');
    Route::get('/amazon-categories', 'Amazon\Categories@list')->name('amazon.categories');

    //Amazon Item Routes
    Route::post('/amazon-items/item/create', 'Asin\Items@createItem')->name('items.create');
    Route::post('/amazon-items/item/update', 'Asin\Items@updateItem')->name('items.update');
    Route::post('/amazon-items/item/edit', 'Asin\Items@editItem')->name('items.edit');
    Route::post('/items/create', 'Asin\Items@create')->name('items.index');

    //Amazon API Settings
    Route::get('/amazon-sp-settings', 'Amazon\Settings@spapisettings')->name('amazon.spapisettings');
    Route::get('/amazon-mws-settings', 'Amazon\Settings@mwsapisettings')->name('amazon.mwsapisettings');
    Route::get('/amazon-pa-settings', 'Amazon\Settings@paapisettings')->name('amazon.paapisettings');
    Route::post('/amazon-settings/spapi/update', 'Amazon\Settings@updateSpApiSettings')->name('amazon.apisettings.updatesp');
    Route::post('/amazon-settings/paapi/update', 'Amazon\Settings@updatePaApiSettings')->name('amazon.apisettings.updatepa');
    Route::post('/amazon-settings/mwsapi/update', 'Amazon\Settings@updateMwsApiSettings')->name('amazon.apisettings.updatemws');

    //Amazon Routes
    Route::get('/amazon-apitest', 'Amazon\Main@getToken')->name('amazon.apitest');
    Route::get('/amazon-fetchAllProducts/{country}', 'Amazon\MwsController@fetchAllProducts')->name('amazon.mwstest');
    Route::get('/amazon-fetchPaProducts/{country}', 'Amazon\PaController@fetchAllProducts')->name('amazon.patest');
    Route::get('/amazon/mwsapi/fetch/{item_id}/{inv_item_id}/{sku}/{ean}/{country}', 'Amazon\MwsController@fetchAmazonItem')->name('amazon.item.fetch');
    Route::get('/amazon-getorders', 'Amazon\SpController@getOrders')->name('amazon.getOrders');

    //Amazon Inventory
    Route::get('/amazon-inventory-request', 'Amazon\Inventory@mwsInventoryRequest')->name('amazon.mwsinventory');
    Route::get('/amazon-inventory-reports', 'Amazon\Inventory@cronGetListingReport')->name('amazon.requestinventoryreport');
    Route::get('/fetch-inventory-reports/{id}', 'Amazon\Inventory@getListingReport')->name('amazon.mwsreportsdownload');
    Route::get('/amazon-inventory-process', 'Amazon\Inventory@processInventory')->name('amazon.processinventory');
});
