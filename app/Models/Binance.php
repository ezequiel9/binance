<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Binance extends Model
{
    protected $table = 'assets';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'binanceId',
        'assetCode',
        'assetName',
        'commissionRate',
        'createTime',
        'isLegalMoney',
        'chineseName',
        'logoUrl',
        'fullLogoUrl',
        'feeRate',
        'feeRate',
        'assetDigit',
        'trading',
    ];






}
