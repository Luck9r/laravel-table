<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches ad data from endpoints';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        echo "Clearing out previous contents of the database...\n";
        try {
            Ad::query()->truncate();
        } catch (Exception $e) {
            echo "An error occurred while executing a query!\n";
            echo $e->getMessage() . "\n" . $e->getTraceAsString();
            return;
        }

        echo "Fetching Ad data from endpoints...\n";
        $response1 = Http::get('https://submitter.tech/test-task/endpoint1.json');
        $response2 = Http::get('https://submitter.tech/test-task/endpoint2.json');
        if ($response1->failed() || $response2->failed()) {
            echo 'Failed to retrieve data from an endpoint!\n';
            return;
        }

        echo "Writing to the database...\n";
        try {
            foreach ($response1->json() as $ad) {
                $adRecord = new Ad;
                $adRecord->ad_id = is_numeric($ad['name']) ? $ad['name'] : null;
                $adRecord->clicks = is_numeric($ad['clicks']) ? $ad['clicks'] : null;
                $adRecord->unique_clicks = is_numeric($ad['unique_clicks']) ? $ad['unique_clicks'] : null;
                $adRecord->leads = is_numeric($ad['leads']) ? $ad['leads'] : null;
                $adRecord->roi = is_numeric($ad['roi']) ? $ad['roi'] : null;
                $adRecord->save();
            }
        } catch (Exception $e) {
            echo "An error occurred while executing a query!\n";
            echo $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
            return;
        }
        try {
            foreach ($response2->json()['data']['list'] as $ad) {
                $adRecord = Ad::where('ad_id', '=', $ad['dimensions']['ad_id'])->update([
                    'conversion' => is_numeric($ad['metrics']['conversion']) ? $ad['metrics']['conversion'] : null,
                    'impressions' => is_numeric($ad['metrics']['impressions']) ? $ad['metrics']['impressions'] : null
                ]);
                if (!$adRecord) {
                    $adRecord = new Ad;
                    $adRecord->ad_id = is_numeric($ad['dimensions']['ad_id']) ? $ad['dimensions']['ad_id'] : null;
                    $adRecord->conversion = is_numeric($ad['metrics']['conversion']) ? $ad['metrics']['conversion'] : null;
                    $adRecord->impressions = is_numeric($ad['metrics']['impressions']) ? $ad['metrics']['impressions'] : null;
                    $adRecord->save();
                }

            }
        } catch (Exception $e) {
            echo "An error occurred while executing a query!\n";
            echo $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
            return;
        }

        echo "Done!\n";
    }
}
