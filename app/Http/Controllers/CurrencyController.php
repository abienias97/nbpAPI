<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    //show all
    public function show() {
        $allListings = Currency::all();
        if($allListings->count()>0){
            return view('getCurrency', [
                'exchangeRates' => $allListings
            ]);
        } else {
            return view('noCurrency');
        }
    }

    //get data from api
    public function get() {
        $currencyData = $this::getFromApi();
        if(count($currencyData[0]['rates'])>0){
            $this->parseCurrency($currencyData[0]['rates']);
            return redirect()->intended('/');
        } else {
            return redirect()->intended('/');
        }
    }

    public static function getFromApi() {
        $client = new Client();

        $response = $client->get('http://api.nbp.pl/api/exchangerates/tables/a/');

        $data = json_decode($response->getBody(), true);

        return($data);
    }

    public static function parseCurrency($allCurrenciesFromApi) {
        if(count($allCurrenciesFromApi)>0){
            foreach($allCurrenciesFromApi as $currencyFromApi){
                $searchedCurrencyIndb=Currency::where('currency_code', $currencyFromApi['code'])->get();
                if($searchedCurrencyIndb->count() > 0){
                    if($searchedCurrencyIndb[0]['exchange_rate'] != $currencyFromApi['mid']){

                        $searchedCurrencyIndb[0]->exchange_rate = $currencyFromApi['mid'];
                        $searchedCurrencyIndb[0]->save();
                        echo 'updating at '.$searchedCurrencyIndb[0]->currency_code.'<br>';
                    }
                } else {
                    $newCurrency = new Currency;
                    $newCurrency->id = NULL;
                    $newCurrency->name = $currencyFromApi['currency'];
                    $newCurrency->currency_code = $currencyFromApi['code'];
                    $newCurrency->exchange_rate = $currencyFromApi['mid'];
                    $newCurrency->save();
                    echo 'saving new currency at '.$newCurrency->name.'<br>';
                }
            }
        }
    }
}
