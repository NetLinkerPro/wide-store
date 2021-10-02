<?php


namespace NetLinker\WideStore\Sections\Check\Repositories;

use Carbon\Carbon;
use NetLinker\WideStore\Sections\ShopProducts\Models\ShopProduct;
use NetLinker\WideStore\Sections\Shops\Models\Shop;
use NetLinker\WideStore\Sections\ShopStocks\Models\ShopStock;

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
        $stockLast = ShopStock::where('shop_uuid', $shop->uuid)->orderBy('updated_at')->first();
        if (!$stockLast){
            return 'Brak stanów w integracji.';
        }
        /** @var Carbon $updatedAt */
        $updatedAt = $stockLast->updated_at;
        if (!$updatedAt){
            return 'Brak aktualizacji stanów.';
        }
        $dateToCompare = now();
        $dateToCompare->subHours($subHours);
        if ($dateToCompare->greaterThan($updatedAt)){
            $message = sprintf('Przestarzała data aktualizacji: %s.', $updatedAt->format('Y-m-d H:i:s'));
            $stockFirst = ShopStock::where('shop_uuid', $shop->uuid)->orderBy('updated_at', 'DESC')->first();
            $updatedAtFirst =  $stockFirst->updated_at;
            if ($updatedAtFirst){
                $message .= sprintf(' Data najnowszej aktualizacji: %s.', $updatedAtFirst->format('Y-m-d H:i:s'));
            }
            return $message;
        }
        return 'ok';
    }
}