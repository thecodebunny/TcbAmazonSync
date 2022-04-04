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
    Route::get('/amazon-producttypes', 'Amazon\Main@ptIndex')->name('amazon.ptindex');
    Route::get('/amazon-product-types-datatables', 'Amazon\Main@productTypeDataTable')->name('amazon.producttype.datatables');
    Route::get('/amazon-producttype/get', 'Amazon\SpApi@getProductTypes')->name('amazon.getProductTypes');

    //Brand Routes
    Route::get('/amazon-brands', 'Amazon\Brand@index')->name('amazon.brands');
    Route::get('/amazon-brands/create', 'Amazon\Brand@create')->name('amazon.brands.create');
    Route::post('/amazon-brands/save', 'Amazon\Brand@save')->name('amazon.brand.save');
    Route::get('/amazon-brands/edit/{id}', 'Amazon\Brand@edit')->name('amazon.brand.edit');
    Route::post('/amazon-brands/update/{id}', 'Amazon\Brand@update')->name('amazon.brand.update');
    Route::post('/amazon-brands/destroy/{id}', 'Amazon\Brand@destroy')->name('amazon.brand.destroy');
    Route::get('/amazon-brands/duplicate/{id}', 'Amazon\Brand@duplicate')->name('amazon.brand.duplicate');

    //Warehouse Routes
    Route::get('/amazon-warehouses', 'Amazon\Warehouse@index')->name('amazon.warehouses');
    Route::get('/amazon-warehouses/create', 'Amazon\Warehouse@create')->name('amazon.warehouses.create');
    Route::post('/amazon-warehouses/save', 'Amazon\Warehouse@save')->name('amazon.warehouse.save');
    Route::get('/amazon-warehouses/edit/{id}', 'Amazon\Warehouse@edit')->name('amazon.warehouse.edit');
    Route::post('/amazon-warehouses/update/{id}', 'Amazon\Warehouse@update')->name('amazon.warehouse.update');
    Route::post('/amazon-warehouses/destroy/{id}', 'Amazon\Warehouse@destroy')->name('amazon.warehouse.destroy');
    Route::get('/amazon-warehouses/duplicate/{id}', 'Amazon\Warehouse@duplicate')->name('amazon.warehouse.duplicate');

    //Menu Routes
    Route::get('/amazon-settings', 'Amazon\Settings@settings')->name('amazon.settings');
    Route::post('/amazon-settings/update', 'Amazon\Settings@update')->name('amazon.settings.update');
    Route::get('/amazon-categories', 'Amazon\Categories@list')->name('amazon.categories');
    Route::get('/amazon-categories-datatables', 'Amazon\Categories@datatable')->name('amazon.categories.datatables');
    Route::get('/amazon-items', 'Amazon\Main@items')->name('amazon.items');
    Route::get('/amazon-items-index/{country}', 'Amazon\Items@index')->name('amazon.items.index');

    //Amazon Item Routes
    Route::post('/amazon-items/item/create', 'Amazon\Items@createItem')->name('items.create');
    Route::post('/amazon-items/item/update/{id}', 'Amazon\Items@updateItem')->name('items.update');
    Route::get('/amazon-items/item/show/{id}/{country}', 'Amazon\Items@showItem')->name('items.show');
    Route::post('/items/create', 'Amazon\Items@create')->name('items.index');
    Route::get('/amazon-items-datatables/{country}', 'Amazon\Items@datatable')->name('amazon.items.datatables');

    //Amazon Order Routes
    Route::get('/amazon-orders', 'Amazon\Orders@index')->name('amazon.orders.index');
    Route::get('/amazon-orders/{id}', 'Amazon\Orders@show')->name('amazon.orders.show');
    Route::get('/amazon-orders/edit/{id}', 'Amazon\Orders@edit')->name('amazon.orders.edit');
    Route::post('/amazon-orders/update/{id}', 'Amazon\Orders@update')->name('amazon.orders.update');
    Route::get('/amazon-order-confirmshipment/{id}', 'Amazon\Orders@confirmShipment')->name('amazon.orders.confirmshipment');
    Route::get('/amazon-ordersitems-update/{country}', 'Amazon\Orders@toRemove')->name('amazon.orders.itemsupdate');

    //Amazon Shipping Routes
    Route::get('/amazon-rates/{id}/{country}', 'Amazon\Shipping@getRates')->name('amazon.orders.getrates');

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
        Route::get('/amazon/item/get/{id}', 'Amazon\SpApi@getItem')->name('amazon.item.get');
        Route::get('/amazon-patchstock/{sku}/{qty}', 'Amazon\SpApi@updateAmazonItemStock')->name('amazon.patchstock');
        Route::get('/amazon-getAplus/{country}', 'Amazon\SpApi@getAplusContents')->name('amazon.aplus');
        Route::get('/amazon-updateitem-onamazon/{id}', 'Amazon\SpApi@updateItemOnAmazon')->name('amazon.updateItemOnAmz');
        Route::get('/amazon/item/restrictions/{asin}', 'Amazon\SpApi@getListingRestrictions')->name('amazon.itemRestrictions');
        Route::get('/amazon/item/upload/{id}', 'Amazon\SpApi@uploadItem')->name('amazon.item.upload');
        Route::get('/amazon/item/update-online/{id}', 'Amazon\SpApi@uploadItem')->name('amazon.item.updateOnline');

        //Product Attributes APIs
        Route::get('/amazon-updatebulletpoints/{id}', 'Amazon\SpApi@updateAmazonItemBulletPoints')->name('amazon.updateBulletpoints');
        Route::get('/amazon-updatecategory/{id}/{category}', 'Amazon\SpApi@updateAmazonItemCategory')->name('amazon.updateCategory');
        Route::get('/amazon-updatekeywords/{id}', 'Amazon\SpApi@updateAmazonItemKeywords')->name('amazon.updateKeywords');
        Route::get('/amazon-updatedescription/{id}', 'Amazon\SpApi@updateAmazonItemDescription')->name('amazon.updateDescription');
        Route::get('/amazon-updatestock/{id}/{qty}', 'Amazon\SpApi@updateAmazonItemStock')->name('amazon.updateStock');
        Route::get('/amazon-updatetitle/{id}/{title}', 'Amazon\SpApi@updateAmazonItemTitle')->name('amazon.updateTitle');
        Route::get('/amazon-updateprice/{id}/{price}/{currency}', 'Amazon\SpApi@updateAmazonItemPrice')->name('amazon.updatePrice');
        Route::get('/amazon-updatesaleprice/{id}/{startdate}/{enddate}/{saleprice}/{currency}', 'Amazon\SpApi@updateAmazonSalePrice')->name('amazon.updateSalePrice');
        Route::get('/amazon-updateimages/{id}', 'Amazon\Feeds\Image@createImageFeedDocument')->name('amazon.updateImages');

        //Orders APIs
        Route::get('/amazon-testApi/{country}', 'Amazon\SpApi@testOrders')->name('amazon.testApi');
        Route::get('/amazon-getOrderAddress/{orderid}', 'Amazon\SpApi@getOrderAddress')->name('amazon.getOrderAddress');
        Route::get('/amazon-confirmshipment/{amzOrderId}/{tid}/{tid2}/{tid3}/{tid4}/{tid5}/{id}/{carrier}', 'Amazon\Feeds\Order@createShippingConfirmationFeedDocument')->name('amazon.confirmordershipment');

        //Feeds APIs
        Route::get('/amazon-upload-item/{id}', 'Amazon\Feeds\Item@createProductFeedDocument')->name('amazon.uploadItem');

        //Reports APIs
        Route::get('/amazon-inventoryreport/{country}', 'Amazon\Reports\Listings@createInventoryReport')->name('amazon.createInventoryReport');
        Route::get('/amazon-readdoc/{id}', 'Amazon\Reports\Listings@readDoc')->name('amazon.readDoc');

    //Amazon Other API Routes
    Route::get('/amazon-fetchAllProducts/{country}', 'Amazon\MwsApi@fetchAllProducts')->name('amazon.mwstest');
    Route::get('/amazon-fetchPaProducts/{country}', 'Amazon\PaApi@fetchAllProducts')->name('amazon.patest');
    Route::get('/amazon/mwsapi/fetch/{item_id}/{ean}', 'Amazon\MwsApi@fetchAmazonItem')->name('amazon.item.fetch');
    Route::get('/amazon-getorders/{country}', 'Amazon\Orders@getOrders')->name('amazon.getOrders');

    //Search Roputes
    Route::post('/amazon-categories/search', 'Amazon\Search@searchCategories')->name('amazon.searchcategories');

});
