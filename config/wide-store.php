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

        'introductions'=> 'NetLinker\WideStore\Sections\Introductions\Controllers\IntroductionController',

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

        'shop_products' => 'NetLinker\WideStore\Sections\ShopProducts\Controllers\ShopProductController',

        'shop_stocks' => 'NetLinker\WideStore\Sections\ShopStocks\Controllers\ShopStockController',

        'shop_categories' => 'NetLinker\WideStore\Sections\ShopCategories\Controllers\ShopCategoryController',

        'shop_product_categories' => 'NetLinker\WideStore\Sections\ShopProductCategories\Controllers\ShopProductCategoryController',

        'shop_images' => 'NetLinker\WideStore\Sections\ShopImages\Controllers\ShopImageController',

        'shop_descriptions' => 'NetLinker\WideStore\Sections\ShopDescriptions\Controllers\ShopDescriptionController',

        'shop_attributes' => 'NetLinker\WideStore\Sections\ShopAttributes\Controllers\ShopAttributeController',

        'my_prices' => 'NetLinker\WideStore\Sections\MyPrices\Controllers\MyPriceController',

        'my_stocks' => 'NetLinker\WideStore\Sections\MyStocks\Controllers\MyStockController',

        'shops' => 'NetLinker\WideStore\Sections\Shops\Controllers\ShopController',

        'deliverers' => 'NetLinker\WideStore\Sections\Deliverers\Controllers\DelivererController',

        'settings' => 'NetLinker\WideStore\Sections\Settings\Controllers\SettingController',

        'configurations' => 'NetLinker\WideStore\Sections\Configurations\Controllers\ConfigurationController',

        'formatters' => 'NetLinker\WideStore\Sections\Formatters\Controllers\FormatterController',
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