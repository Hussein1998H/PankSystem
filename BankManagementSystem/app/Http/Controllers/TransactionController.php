<?php

namespace App\Http\Controllers;

use App\Models\Acc_money;
use App\Models\Account;
use App\Models\Customer;
use App\Models\mony;
use App\Models\Transaction;
use App\Models\TransactioReport;
use CurrencyApi\CurrencyApi\CurrencyApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


//        if (!auth()->user()->tokenCan('admin')){
//
//            return response()->json([
//                'message'=>'you Dont Have permission'
//            ],400);
//        }
//        $transacton=Transaction::with('account')->get();


//        $customers = Customer::with('accounts.transachs')->get();
        $customers = Customer::with('accounts.transachs')->get();

        return response()->json([
            'data'=>$customers,

        ],200);



//        foreach ($customers as $customer) {
//         $customerFrom= $customer->firstName . " ". $customer->lastName;
//
//
//            foreach ($customer->accounts as $account) {
//                foreach ($account->transachs as $transaction) {
//                    $accountNumber=$transaction->account_from_id;
//                    $accountNumberto=$transaction->account_to_id;
//
//                    $senderAccount = Account::find($transaction->account_to_id);
//                    if ($senderAccount) {
//                        $senderCustomer = $senderAccount->customer;
//                        $senderCustomer=$senderCustomer->firstName." ".$senderCustomer->lastName;
//                    }
//                }
//            }
//        }




//

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dotransaction(Request $request){



        try {

            $typeTo=mony::where('type',$request->typeto)->first();

            $accountto=Account::with('accmonies')->where('accountNumber',$request->accountNumberTo)->first();
            $customerTo=Customer::find($accountto->customer_id);

//            $personbalanceto=Acc_money::where('acc_id',$accountto->id)->where('money_id',$mony->id)->first();

            $personbalanceto=Acc_money::where('acc_id',$accountto->id)->where('money_id',$typeTo->id)->first();


            if (!$personbalanceto){
                Acc_money::create([
                    'acc_id'=>$accountto->id,
                    'money_id'=>$typeTo->id,
                ]);
               return response()->json([
                   'Erorr'=>'The Person That  You Well Translate Mony Dont Have Account With This Type Of Mony  we Well Open To Him  Please Try Agin After A few mintets ',
               ]);

            }
            else {
                DB::beginTransaction();
                $type = $request->typemony;
                $accountfrom = Account::with('accmonies')->where('accountNumber', $request->accountNumberFrom)->first();
                 $customerFrom=Customer::find($accountfrom->customer_id);
                $mony = mony::where('type', $type)->first();

                $personbalancefrom = Acc_money::where('acc_id', $accountfrom->id)->where('money_id', $mony->id)->first();
                $amount = $request->amount;


                if ($personbalancefrom->balance < $amount) {

                    return response()->json([
                        'Error' => 'Your Account balance less Than That',

                    ], 400);
                }
                if (!$accountfrom->isActive) {
                    return response()->json([
                        'Error' => 'Your Account  Is Blocked',


                    ], 400);
                }

                if (!$accountto->isActive) {
                    return response()->json([
                        'Error' => 'The Account you will To  send Money Is Blocked',

                    ], 400);

                }

                $personbalancefrom->balance -= $amount;


                $currencyapi = new CurrencyApiClient('cur_live_G8rj9dFObmcdf6rElJ9gtIzVjIDLSxbAnki5p03h');

                $test = $fromdata = $currencyapi->latest([
                    'base_currency' => $request->typemony,
                    'currencies' => $request->typeto
                ]);
                $forone = $test['data'][$request->typeto]['value'];
                $finaldata = $amount * $forone;

                $personbalanceto->balance += $finaldata;

                $personbalancefrom->save();
                $personbalanceto->save();

                $transaction = Transaction::create([
                    'account_id' => $accountfrom->id,
                    'account_from_id' => $accountfrom->accountNumber,
                    'account_to_id' => $accountto->accountNumber,
                    'trans_date' => now(),
                    'balance' => $amount,
                    'type' => $type,
                    'description' => $request->description,
                ]);
                TransactioReport::create([
                    'FromCustomer'=>$customerFrom->firstName." ".$customerFrom->lastName,
                    'ToCustomer'=>$customerTo->firstName." ".$customerTo->lastName,
                    'AccountNumberFrom'=> $accountfrom->accountNumber,
                    'AccountNumberTo'=>$accountto->accountNumber,
                    'trans_date' => now(),
                    'balance'=> $amount,
                    'description'=> $request->description,
                ]);

                DB::commit();


                return response()->json([
//                'dataAccountfrom'=>$accountFrom,
//                'accountNumberFrom'=>$accountNumberFrom,
//                'balanceFrom'=>$balanceFrom,
//                'dataAccountTo'=>$accountTo,
//                'accountNumberTo'=>$accountNumberTo,
//                'balanceTo'=>$balanceTo,
                    'data' => $transaction,
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'Error'=>"حدث خطأ أثناء المعاملة: " . $e->getMessage(),
            ],400);
        }

    }
    public function store(Request $request)
    {
//        try {
//            DB::beginTransaction();
//            $type=$request->typemony;
//            $customerfrom=Customer::where('ID_number',$request->From_ID_number)->with('accounts')->first();
//            $customerto=Customer::where('ID_number',$request->To_ID_number)->with('accounts')->first();
//            $mony=mony::where('type',$type)->first();
//           // $personbalancefrom=Acc_money::where('acc_id',$account->id)->where('money_id',$mony->id)->first();
//            $amount=$request->amount;
//            //  $accountNumberFrom=0;
//            //   $accountNumberTo=0;
////        $balanceFrom=0;
//            if (!$customerfrom || !$customerto){
//                return response([
//                    'Error'=>'This customer Not Found',
//                ],400);
//            }
//            foreach ($customerfrom->accounts as $accountFrom){
//                $accountFrom= $accountFrom->where('accountNumber',$request->accountNumberFrom)->first();
//                if (!$accountFrom){
//                    return response([
//                        'Error'=>'This Account Not Found',
//                    ],400);
//                }
//                $balanceFrom=$accountFrom->balance;
//            }
//
//            $accountNumberFrom=$accountFrom->accountNumber;
//
//            foreach ($customerto->accounts as $accountTo){
//                $accountTo= $accountTo->where('accountNumber',$request->accountNumberTo)->first();
//                if (!$accountTo){
//                    return response([
//                        'Error'=>'This Account Not Found',
//                    ],400);
//                }
//                $balanceTo=$accountTo->balance;
//            }
//            $accountNumberTo=$accountTo->accountNumber;
//
//            if ($accountFrom->balance < $amount){
//
//                return response()->json([
//                    'Error'=>'Your Account balance less Than That',
//
//                ],400);
//            }
//            if (!$accountFrom->isActive)
//            {
//                return response()->json([
//                    'Error'=>'Your Account  Is Blocked',
//
//
//                ],400);
//            }
//
//            if ( !$accountTo->isActive)
//            {
//                return response()->json([
//                    'Error'=>'The Account you will To  send Money Is Blocked',
//
//                ],400);
//
//            }
//
//            $accountFrom->balance -=$amount;
//            $accountTo->balance+=$amount;
//
//            $accountFrom->save();
//            $accountTo->save();
//
//            $transaction=Transaction::create([
//                'account_id'=>$accountFrom->id,
//                'account_from_id'=>$accountNumberTo,
//                'account_to_id'=>$accountNumberFrom,
//                'trans_date'=>now(),
//                'balance'=>$amount,
//                'description'=>$request->description,
//            ]);
//
//            DB::commit();
//
//
//            return response()->json([
////                'dataAccountfrom'=>$accountFrom,
////                'accountNumberFrom'=>$accountNumberFrom,
////                'balanceFrom'=>$balanceFrom,
////                'dataAccountTo'=>$accountTo,
////                'accountNumberTo'=>$accountNumberTo,
////                'balanceTo'=>$balanceTo,
//                'data'=>$transaction,
//            ],200);
//
//        } catch (\Exception $e) {
//            DB::rollback();
//            return response()->json([
//                'Error'=>"حدث خطأ أثناء المعاملة: " . $e->getMessage(),
//            ],400);
//        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
    public function myTransaction(){

        $user=Auth::user();
        $account=$user->accounts;
//        $transaction=Transaction::whereIn('account_id',$account->pluck('id'))->get();
        $transactionR=TransactioReport::whereIn('AccountNumberFrom',$account->pluck('accountNumber'))->get();

        return response()->json([
//            'Accounts'=>$account,
//            'Transaction'=>$transaction,
           'data'=>$transactionR
        ],200);
    }
}
