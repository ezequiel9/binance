<?php

namespace App\Http\Controllers;

use App\Models\Binance;
use Carbon\Carbon;

class BinanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getData()
    {
        try {
            // create curl resource
            $ch = curl_init();
            // set url
//            $time = time();
//            $page = 2;
//            $pageSize = 100;
//            $url = "https://www.binance.com/gateway-api/v1/public/indicator/abnormal-trading-notice/pageList?pageIndex={$page}&pageSize={$pageSize}&startTime={$time}&endTime={$time}";
            $url = "https://www.binance.com/exchange-api/v2/public/asset/asset/get-all-asset";

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $assets = curl_exec($ch);
            curl_close($ch);
            $assets = json_decode($assets);

            $existingAssetsKeys = Binance::all()->keyBy('assetCode')->keys()->toArray();

            $assetFields = new Binance();
            $assetFields = $assetFields->getFillable();

            $newAssets = [];
            if (!empty($assets->data) && is_array($assets->data)) {
                foreach ($assets->data as $asset) {
                    $loopAsset = [];
                    $asset->createTime = Carbon::createFromTimestamp($asset->createTime)->format('Y-m-d H:i:s');

                    foreach ($assetFields as $assetField) {
                        if (array_key_exists($assetField, (array) $asset)) {
                            $loopAsset[$assetField] = $asset->$assetField;
                        }
                    }
                    //dd($asset->createTime);
                    if (in_array($asset->assetCode, $existingAssetsKeys)) {
                        // code already here, just update it.
                        Binance::query()
                            ->where('assetCode', $asset->assetCode)
                            ->update($loopAsset);
                    }

                    else {
                        // new code, create and notify
                        $newAssets[] = Binance::query()
                            ->where('assetCode', $asset->assetCode)
                            ->create($loopAsset);
                    }
                }
            }

//            return Binance::query()->inRandomOrder()->limit(1)->get();
            return $newAssets;

        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
}
