<?php

use App\Models\mony;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Route::get('test',function (){
    $usd=mony::where('type','USD')->first();
return $usd->id;
});

Route::get('testEmail',function (){
   \Illuminate\Support\Facades\Mail::to('kaheralahzan89@gmail.com')->send(new \App\Mail\SendEmailFrom());
});
