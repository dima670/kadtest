<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

class GetCurrentRate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "get:rate";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Получить текущий курс";

    public function handle()
    {
        $client = new Client();

        $today = date('d/m/Y');

        $currencies = DB::select("SELECT id, digit_code FROM currencies");

        $currencies = array_map(function ($value) {
            return (array) $value;
        }, $currencies);

        $currenciesData = $client->get("http://www.cbr.ru/scripts/XML_daily.asp?date_req=$today")->getBody()->getContents();

        $xml = new SimpleXMLElement($currenciesData);

        foreach($xml->xpath('Valute') as $currency) {
            $key = array_search($currency->NumCode, array_column($currencies, 'digit_code'));

            if ($key) {
                $idCurrency = $currencies[$key]['id'];
                $value = str_replace(',', '.', $currency->Value);

                DB::insert("INSERT INTO rate (currency_id, value) VALUES ($idCurrency, $value)");
            }
        }
    }
}
