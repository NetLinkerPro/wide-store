<?php


namespace NetLinker\WideStore\Sections\Check\Repositories;

use Carbon\Carbon;
use NetLinker\WideStore\Sections\ShopProducts\Models\ShopProduct;
use NetLinker\WideStore\Sections\Shops\Models\Shop;

class CheckRepository
{
    public function getMessageValid(array $input): string
    {
        $shopId = $input['shopId'] ?? '';
        $subHours = (int) ($input['subHours'] ?? 48);
        $shop = Shop::where('id', $shopId)->first();
        if (!$shop){
            return 'Sklep nie istnieje.';
        }
        $productLast = ShopProduct::where('shop_uuid', $shop->uuid)->orderBy('updated_at')->first();
        if (!$productLast){
            return 'Brak produktów w integracji.';
        }
        /** @var Carbon $updatedAt */
        $updatedAt = $productLast->updated_at;
        if (!$updatedAt){
            return 'Brak aktualizacji w produkcie.';
        }
        $dateToCompare = now();
        $dateToCompare->subHours($subHours);
        if ($dateToCompare->greaterThan($updatedAt)){
            return sprintf('Przestarzała data aktualizacji: %s.', $updatedAt->format('Y-m-d H:i:s'));
        }
        return 'ok';
    }
}