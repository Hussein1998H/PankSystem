<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\Customers\CustomerAuthController;
use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});




//Route::middleware("auth:sanctum")->group(function () {});

Route::post('/user/createUser',[UserAuthController::class,'createUser'])->middleware(['auth:sanctum','isAdmin']);
//->middleware(['auth:sanctum','isAdmin'])
Route::get('/user/profile',[UserAuthController::class,'profile'])->middleware(['auth:sanctum','isUser']);


//Route::post('/user/forgetPassword',[UserAuthController::class,'forgetPassword']);
//Route::post('/user/resetPassword',[UserAuthController::class,'resetPassword']);
//Route::post('/user/login',[UserAuthController::class,'loginUser']);
//Route::post('/user/logout',[UserAuthController::class,'logout'])->middleware('auth:sanctum');


Route::post('/customer/createCustomer',[CustomerAuthController::class,'createcustomer'])->middleware(['isUser','auth:sanctum']);
//
Route::get('/customer/profile',[CustomerAuthController::class,'customerprofile'])->middleware('auth:sanctum');
Route::resource('customers',CustomerController::class)->middleware('auth:sanctum');


//Route::post('/customer/login',[CustomerAuthController::class,'customerlogin']);
//Route::post('/customer/logout',[CustomerAuthController::class,'customerlogout'])->middleware('auth:sanctum');
//Route::post('/customer/forgetPassword',[CustomerAuthController::class,'forgetPassword']);
//Route::post('/customer/resetPassword',[CustomerAuthController::class,'resetPassword']);
//Route::post('/customer/update/{id}',[CustomerAuthController::class,'update'])->middleware('auth:sanctum');



Route::get('user/index',[UserController::class,'index']);
Route::get('user/edit/{id}',[UserController::class,'edit']);
Route::patch('user/update/{id}',[UserController::class,'update']);
Route::delete('user/destroy/{id}',[UserController::class,'destroy']);


Route::resource('transactions',TransactionController::class)->middleware('auth:sanctum');
Route::get('myTramsaction',[TransactionController::class,'myTransaction'])->middleware('auth:sanctum');
Route::post('dotransaction',[TransactionController::class,'dotransaction'])->middleware('auth:sanctum');
Route::post('convertMony',[TransactionController::class,'convertMony'])->middleware('auth:sanctum');
//->middleware('auth:sanctum')
Route::resource('withdraw',WithdrawController::class)->middleware('auth:sanctum');
Route::post('withdrawHistory',[WithdrawController::class,'withdrawHistory'])->middleware('auth:sanctum');
Route::get('mywithdraw',[WithdrawController::class,'mywithdraw'])->middleware('auth:sanctum');


Route::resource('deposit',DepositController::class)->middleware('auth:sanctum');
Route::post('depositHistory',[DepositController::class,'depositHistory'])->middleware('auth:sanctum');
Route::get('mydeposit',[DepositController::class,'mydeposit'])->middleware('auth:sanctum');


Route::resource('accounts',AccountController::class)->middleware('auth:sanctum');
Route::get('showmyaccunt',[AccountController::class,'showaccunt'])->middleware('auth:sanctum');
Route::post('accounts/blockAccount',[AccountController::class,'blockAccount'])->middleware('auth:sanctum');
Route::post('accounts/unblockAccount',[AccountController::class,'unblockAccount'])->middleware('auth:sanctum');

Route::resource('branches',BranchController::class)->middleware('auth:sanctum');
Route::get('allbranches',[BranchController::class,'getBranches']);


//Route::controller(AuthController::class)->group(function (){
//
//});

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('refreshToken',[AuthController::class,'refreshToken'])->middleware('auth:sanctum');
Route::post('forgetPassword',[AuthController::class,'forgetPassword']);
Route::post('resetPassword',[AuthController::class,'resetPassword']);

Route::get('AllCurrency',[CurrencyController::class,'index']);
Route::post('ConvertMony',[CurrencyController::class,'convertMony']);

Route::get('TransactionReport',[\App\Http\Controllers\TransactioReportController::class,'index'])->middleware(['auth:sanctum','isUser']);
Route::get('reportCount',[\App\Http\Controllers\TransactioReportController::class,'reportCount']);

Route::post('AddUser',[UserRoleController::class,'createUser']);
