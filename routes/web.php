<?php

use App\Models\Currency;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $allListings = Currency::all();
    if($allListings->count()>0){
        return view('getCurrency', [
            'exchangeRates' => $allListings
        ]);
    } else {
        return view('noCurrency');
    }

});
