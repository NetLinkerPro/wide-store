# WideStore

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

NetLinker module for store products with front <a href="https://awes.io" target="_blank">AWES.io</a>.

## Installation

Via Composer

``` bash
$ composer require netlinker/wide-store
```

## Usage

Documentation location is [here][link-documentation]

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ ./vendor/bin/dusk-updater detect --auto-update && PKGKIT_CDN_KEY=xxx WIDE_STORE_OVH_URL=xxx 
WIDE_STORE_OVH_USER=xxx WIDE_STORE_OVH_PASS=xxx WIDE_STORE_OVH_USER_DOMAIN=Default WIDE_STORE_OVH_REGION=xxx 
WIDE_STORE_OVH_TENANT_NAME=xxx WIDE_STORE_OVH_CONTAINER=xxx WIDE_STORE_OVH_PROJECT_ID=xxx WIDE_STORE_OVH_URL_KEY=xxx 
WIDE_STORE_OVH_CUSTOM_ENDPOINT=xxx REDIS_HOST=0.0.0.0 REDIS_PASSWORD=secret ./vendor/bin/phpunit
```

For tests can be set all setting from `.env` file as `REDIS_PORT=6379`.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [NetLinker][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/netlinker/wide-store.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/netlinker/wide-store.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/netlinker/wide-store/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/netlinker/wide-store
[link-downloads]: https://packagist.org/packages/netlinker/wide-store
[link-travis]: https://travis-ci.org/NetLinkerPro/wide-store
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/netlinker
[link-contributors]: ../../contributors
[link-documentation]: https://netlinker.pro/docs/modules/wide-store
