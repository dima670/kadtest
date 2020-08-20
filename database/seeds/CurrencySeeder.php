<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            ['name' => 'Российский рубль', 'english_name' => 'Russian ruble', 'alphabetic_code' => 'RUB', 'digit_code' => '643'],
            ['name' => 'Доллар США', 'english_name' => 'Dollar USA', 'alphabetic_code' => 'USD', 'digit_code' => '840'],
            ['name' => 'Евро', 'english_name' => 'EURO', 'alphabetic_code' => 'EUR', 'digit_code' => '978'],
        ];

        DB::table('currencies')->insert($currencies);
    }
}
