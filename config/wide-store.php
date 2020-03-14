<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Owner
    |--------------------------------------------------------------------------
    |
    | Owner class for automation add owner to model.
    |
    */

    'owner' => [
        'model' => 'NetLinker\WideStore\Tests\Stubs\Owner',
        'field_auth_user_owner_uuid' => 'owner_uuid',
    ],

    /*
   |--------------------------------------------------------------------------
   | Domain
   |--------------------------------------------------------------------------
   |
   | Route domain for module WideStore. If null, domain will be
   | taken from `app.url` config.
   |
   */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | Route prefix for module WideStore.
    |
    */

    'prefix' => 'wide-store',


    /*
    |--------------------------------------------------------------------------
    | Web middleware
    |--------------------------------------------------------------------------
    |
    | Middleware for routes module WideStore. Value is array.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Controllers
    |--------------------------------------------------------------------------
    |
    | Namespaces for controllers.
    |
    */

    'controllers' => [

        'assets' => 'NetLinker\WideStore\Sections\Assets\Controllers\AssetController',

        'dashboard' => 'NetLinker\WideStore\Sections\Dashboard\Controllers\DashboardController',

        'identifiers' => 'NetLinker\WideStore\Sections\Identifiers\Controllers\IdentifierController',

        'products' => 'NetLinker\WideStore\Sections\Products\Controllers\ProductController',

        'names' => 'NetLinker\WideStore\Sections\Names\Controllers\NameController',

        'urls' => 'NetLinker\WideStore\Sections\Urls\Controllers\UrlController',

        'prices' => 'NetLinker\WideStore\Sections\Prices\Controllers\PriceController',

        'taxes' => 'NetLinker\WideStore\Sections\Taxes\Controllers\TaxController',

        'stocks' => 'NetLinker\WideStore\Sections\Stocks\Controllers\StockController',

        'categories' => 'NetLinker\WideStore\Sections\Categories\Controllers\CategoryController',

        'product_categories' => 'NetLinker\WideStore\Sections\ProductCategories\Controllers\ProductCategoryController',

        'images' => 'NetLinker\WideStore\Sections\Images\Controllers\ImageController',

        'descriptions' => 'NetLinker\WideStore\Sections\Descriptions\Controllers\DescriptionController',

        'attributes' => 'NetLinker\WideStore\Sections\Attributes\Controllers\AttributeController',

        'introductions'=> 'NetLinker\WideStore\Sections\Introductions\Controllers\IntroductionController',

    ],

    /*
    |--------------------------------------------------------------------------
    | Queues
    |--------------------------------------------------------------------------
    |
    | Name queues
    |
    */

    'queues' => [],

];