<?php

namespace App\Console\Commands;

use App\Models\CurrencyRate;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-currency-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency rates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rates = $this->fetchRatesFromApiLayer();
        if (count($rates) > 0) {

            CurrencyRate::create([
                'from' => 'USD',
                'to' => 'RUB',
                'rate' => $rates['rates']['RUB']
            ]);

            CurrencyRate::create([
                'from' => 'RUB',
                'to' => 'USD',
                'rate' => 1.0 / $rates['rates']['RUB']
            ]);
        }
    }

    private function fetchRatesFromApiLayer()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.apilayer.com/fixer/latest?base=USD&symbols=RUB', [
            'headers' => [
                'apikey' => 'O2ZC72eBmMeb3VIImJ51CC8dVBW6tMZ2',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
