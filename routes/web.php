<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::domain(config('wide-store.domain'))
    ->name('wide-store.')
    ->prefix(config('wide-store.prefix'))
    ->middleware(config('wide-store.middleware'))
    ->group(function () {

        # Assets AWES
        Route::get('assets/{module}/{type}/{filename}', config('wide-store.controllers.assets') . '@getAwes')->name('assets.awes');

        # Dashboard
        Route::prefix('/')->as('dashboard.')->group(function () {
            Route::get('/', config('wide-store.controllers.dashboard') . '@index')->name('index');
        });

        # Introductions
        Route::prefix('introductions')->as('introductions.')->group(function () {
            Route::get('/', config('wide-store.controllers.introductions') . '@index')->name('index');
        });

        # Identifiers
        Route::prefix('identifiers')->as('identifiers.')->group(function () {
            Route::get('/', config('wide-store.controllers.identifiers') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.identifiers') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.identifiers') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.identifiers') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.identifiers') . '@destroy')->name('destroy');
        });

        # Products
        Route::prefix('products')->as('products.')->group(function () {
            Route::get('/', config('wide-store.controllers.products') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.products') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.products') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.products') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.products') . '@destroy')->name('destroy');
        });


        # Names
        Route::prefix('names')->as('names.')->group(function () {
            Route::get('/', config('wide-store.controllers.names') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.names') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.names') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.names') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.names') . '@destroy')->name('destroy');
        });

        # Urls
        Route::prefix('urls')->as('urls.')->group(function () {
            Route::get('/', config('wide-store.controllers.urls') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.urls') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.urls') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.urls') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.urls') . '@destroy')->name('destroy');
        });

        # Prices
        Route::prefix('prices')->as('prices.')->group(function () {
            Route::get('/', config('wide-store.controllers.prices') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.prices') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.prices') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.prices') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.prices') . '@destroy')->name('destroy');
        });

        # Taxes
        Route::prefix('taxes')->as('taxes.')->group(function () {
            Route::get('/', config('wide-store.controllers.taxes') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.taxes') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.taxes') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.taxes') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.taxes') . '@destroy')->name('destroy');
        });

        # Stocks
        Route::prefix('stocks')->as('stocks.')->group(function () {
            Route::get('/', config('wide-store.controllers.stocks') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.stocks') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.stocks') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.stocks') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.stocks') . '@destroy')->name('destroy');
        });

        # Categories
        Route::prefix('categories')->as('categories.')->group(function () {
            Route::get('/', config('wide-store.controllers.categories') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.categories') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.categories') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.categories') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.categories') . '@destroy')->name('destroy');
        });

        # Product categories
        Route::prefix('product-categories')->as('product_categories.')->group(function () {
            Route::get('/', config('wide-store.controllers.product_categories') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.product_categories') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.product_categories') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.product_categories') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.product_categories') . '@destroy')->name('destroy');
        });

        # Images
        Route::prefix('images')->as('images.')->group(function () {
            Route::get('/', config('wide-store.controllers.images') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.images') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.images') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.images') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.images') . '@destroy')->name('destroy');
        });

        # Descriptions
        Route::prefix('descriptions')->as('descriptions.')->group(function () {
            Route::get('/', config('wide-store.controllers.descriptions') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.descriptions') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.descriptions') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.descriptions') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.descriptions') . '@destroy')->name('destroy');
        });

        # Attributes
        Route::prefix('attributes')->as('attributes.')->group(function () {
            Route::get('/', config('wide-store.controllers.attributes') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.attributes') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.attributes') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.attributes') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.attributes') . '@destroy')->name('destroy');
        });

        # Shop products
        Route::prefix('shop-products')->as('shop_products.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_products') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_products') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_products') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_products') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_products') . '@destroy')->name('destroy');
        });

        # Shop stocks
        Route::prefix('shop-stocks')->as('shop_stocks.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_stocks') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_stocks') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_stocks') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_stocks') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_stocks') . '@destroy')->name('destroy');
        });

        # Shop categories
        Route::prefix('shop-categories')->as('shop_categories.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_categories') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_categories') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_categories') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_categories') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_categories') . '@destroy')->name('destroy');
        });

        # Shop product categories
        Route::prefix('shop-product-categories')->as('shop_product_categories.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_product_categories') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_product_categories') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_product_categories') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_product_categories') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_product_categories') . '@destroy')->name('destroy');
        });

        # Shop images
        Route::prefix('shop-images')->as('shop_images.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_images') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_images') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_images') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_images') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_images') . '@destroy')->name('destroy');
        });

        # Shop descriptions
        Route::prefix('shop-descriptions')->as('shop_descriptions.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_descriptions') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_descriptions') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_descriptions') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_descriptions') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_descriptions') . '@destroy')->name('destroy');
        });

        # Shop attributes
        Route::prefix('shop-attributes')->as('shop_attributes.')->group(function () {
            Route::get('/', config('wide-store.controllers.shop_attributes') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shop_attributes') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.shop_attributes') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shop_attributes') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shop_attributes') . '@destroy')->name('destroy');
        });

        # My prices
        Route::prefix('my-prices')->as('my_prices.')->group(function () {
            Route::get('/', config('wide-store.controllers.my_prices') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.my_prices') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.my_prices') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.my_prices') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.my_prices') . '@destroy')->name('destroy');
        });

        # My stocks
        Route::prefix('my-stocks')->as('my_stocks.')->group(function () {
            Route::get('/', config('wide-store.controllers.my_stocks') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.my_stocks') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.my_stocks') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.my_stocks') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.my_stocks') . '@destroy')->name('destroy');
        });

        # Shops
        Route::prefix('shops')->as('shops.')->group(function () {
            Route::get('/', config('wide-store.controllers.shops') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.shops') . '@scope')->name('scope');
            Route::get('search', config('wide-store.controllers.shops') . '@search')->name('search');
            Route::post('store', config('wide-store.controllers.shops') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.shops') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.shops') . '@destroy')->name('destroy');
        });

        # Deliverers
        Route::prefix('deliverers')->as('deliverers.')->group(function () {
            Route::get('scope', config('wide-store.controllers.deliverers') . '@scope')->name('scope');
        });

        # Settings
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/', config('wide-store.controllers.settings') . '@index')->name('index');
            Route::get('scope', config('wide-store.controllers.settings') . '@scope')->name('scope');
            Route::post('store', config('wide-store.controllers.settings') . '@store')->name('store');
            Route::patch('{id?}', config('wide-store.controllers.settings') . '@update')->name('update');
            Route::delete('{id?}', config('wide-store.controllers.settings') . '@destroy')->name('destroy');
        });

        # Formatters
        Route::prefix('formatters')->as('formatters.')->group(function () {
            Route::get('scope', config('wide-store.controllers.formatters') . '@scope')->name('scope');
        });

        # Configurations
        Route::prefix('configurations')->as('configurations.')->group(function () {
            Route::get('scope', config('wide-store.controllers.configurations') . '@scope')->name('scope');
        });
});

Route::domain(config('wide-store.domain'))
    ->name('ws.')
    ->prefix('ws')
    ->middleware(['web'])
    ->group(function () {

        # Check
        Route::prefix('check')->as('check.')->group(function () {
            Route::get('/',   'NetLinker\WideStore\Sections\Check\Controllers\CheckController@index')->name('index');
        });
    });




