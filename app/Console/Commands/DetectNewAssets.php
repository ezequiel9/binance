<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Helpers\SlackHelper;
use App\Http\Controllers\BinanceController;
use Exception;
use Illuminate\Console\Command;


/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class DetectNewAssets extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "binance:detect";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Detect new assets";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            $newAssets = $this->detect();

            if (!empty($newAssets)) {

                foreach ($newAssets as $newAsset) {

                    $message = "Asset: {$newAsset->assetCode}\n";
                    $message .= "Created at: {$newAsset->created_at}\n";
                    SlackHelper::notifySlack($message,true);

                }

                $this->info("New asset/s found");

            }

        } catch (Exception $e) {

            $this->error("An error occurred");

        }

	//SlackHelper::notifySlack('eh put', true);
    }

    private function detect()
    {
        $binance = new BinanceController();
        return $binance->getData();
    }
}
