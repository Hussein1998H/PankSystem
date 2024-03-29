<?php

namespace App\Http\Controllers;

use CurrencyApi\CurrencyApi\CurrencyApiClient;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(){


//        $currencyapi = new CurrencyApiClient('cur_live_G8rj9dFObmcdf6rElJ9gtIzVjIDLSxbAnki5p03h');
        $currencyapi = new CurrencyApiClient('cur_live_sX0cEf48NHZKCCrqdeZPz2I2bXjePFCoR5DlrpEf');
        return response()->json($currencyapi->latest());
//        currencies   latest
    }




    public function convertMony(Request $request){

//        $currencyapi = new CurrencyApiClient('cur_live_G8rj9dFObmcdf6rElJ9gtIzVjIDLSxbAnki5p03h');
        $currencyapi = new CurrencyApiClient('cur_live_sX0cEf48NHZKCCrqdeZPz2I2bXjePFCoR5DlrpEf');

        $value=$request->value;

       $test= $fromdata=$currencyapi->latest([
             'base_currency' => $request->from,
             'currencies'=> $request->to
         ]);
       $forone= $test['data'][$request->to]['value'];
       $finaldata=$value*$forone;

        return response()->json($finaldata);


    }
}
