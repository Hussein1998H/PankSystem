<?php

namespace App\Http\Controllers;

use App\Models\Acc_money;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\mony;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->tokenCan('admin')){

            return response()->json([
                'message'=>'you Dont Have permission'
            ],400);
        }
        $deposit= Deposit::all();
        return response()->json([
            'data'=>$deposit,
        ],200);
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user=Auth::user();
            $type=$request->typemony;
            $account=Account::with('accmonies')->where('accountNumber',$request->accountNumber)->first();
            $mony=mony::where('type',$type)->first();
            $personbalance=Acc_money::where('acc_id',$account->id)->where('money_id',$mony->id)->first();
            $amount=$request->amount;
            if ($personbalance==null){
                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$mony->id,
                    'balance'=>$amount,
                ]);
            }


            //  $accountNumberFrom=0;
            //   $accountNumberTo=0;
            //        $balanceFrom=0;
            if (!$account ){
                return response([
                    'Error'=>'This Account Not Found',
                ],400);
            }

//            if ($account->balance < $amount){
//
//                return response()->json([
//                    'Error'=>'Your Account balance less Than That',
//
//                ],400);
//            }
            if (!$account->isActive)
            {
                return response()->json([
                    'Error'=>'Your Account  Is Blocked',
                ],400);
            }


            $personbalance->balance +=$amount;


            $personbalance->save();


            $deposit=Deposit::create([
                'account_id'=>$account->id,
                'type'=>$type,
                //ملاحظة ضيف رقم الهوية الى الجدول وممكن بلا
                'user_id'=>$user->id,
                'balance'=>$amount,
                'deposit_date'=>now(),
            ]);

            DB::commit();


            return response()->json([

                'data'=>$deposit,
            ],200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'Error'=>"حدث خطأ أثناء المعاملة: " . $e->getMessage(),
            ],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
    public function depositHistory(Request $request){  //للاستفسار عن طريق الموظف
        $account=Account::where('accountNumber',$request->accountNumber)->first();

        $deposit=Deposit::where('account_id',$account->id)->get();

        return response()->json([
            'Accounts'=>$deposit,
        ],200);
    }
    public function mydeposit(){ // للاستفسار من حساب الزبون عن حسابه

        $user=Auth::user();
        $account=$user->accounts;
        $deposit=Deposit::whereIn('account_id',$account->pluck('id'))->get();
        return response()->json([
            'Accounts'=>$account,
            'withdraw'=>$deposit,
        ],200);
    }
}
