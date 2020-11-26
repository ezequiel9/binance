<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

/**
 * Created by PhpStorm.
 * User: Ezequiel
 * Date: 2/04/2020
 * Time: 6:28 PM
 */
class SlackHelper
{

    /**
     * Send a message to the "website-notificatoins" slack channel
     *
     * @param $message
     * @param bool $angry
     * @param array $args override the args with this...
     */
    public static function notifySlack($message, $angry = false, $args = [])
    {
        $slack_channel = 'https://hooks.slack.com/services/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';
        if (empty($args)) {
            $args = [
                "attachments" => [
                    [
                        "fallback" => 'Binance:'.$message,
                        "color" => $angry ? '#ff0000' : "#36a64f",
                        "title" => "New Asset",
                        "text" => $message,
                    ]
                ],
            ];
        }

        $response = Http::post($slack_channel, $args);
    }

}
