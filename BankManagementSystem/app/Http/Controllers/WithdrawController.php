<?php

namespace App\Http\Controllers;

use App\Models\Acc_money;
use App\Models\Account;
use App\Models\mony;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('isCustomer')->only('mywithdraw');
//        $this->middleware('isUser');

    }

    public function index()
    {
        if (!auth()->user()->tokenCan('admin')){

            return response()->json([
                'message'=>'you Dont Have permission'
            ],400);
        }
        $withdraws= Withdraw::all();
        return response()->json([
            'data'=>$withdraws,
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
            if (!auth()->user()->tokenCan('user') && !auth()->user()->tokenCan('admin')){

                return response()->json([
                    'message'=>'you Dont Have permission'
                ],400);
            }

            DB::beginTransaction();

            $user=Auth::user();
            $type=$request->typemony;
            $account=Account::with('accmonies')->where('accountNumber',$request->accountNumber)->first();
            $mony=mony::where('type',$type)->first();
            $personbalance=Acc_money::where('acc_id',$account->id)->where('money_id',$mony->id)->first();
            $amount=$request->amount;
            //  $accountNumberFrom=0;
            //   $accountNumberTo=0;
            //        $balanceFrom=0;
            if (!$account ){
                return response([
                    'Error'=>'This Account Not Found',
                ],400);
            }


            if ($personbalance->balance < $amount){

                return response()->json([
                    'Error'=>'Your Account balance less Than That',

                ],400);
            }
            if (!$account->isActive)
            {
                return response()->json([
                    'Error'=>'Your Account  Is Blocked',


                ],400);
            }


            $personbalance->balance -=$amount;


            $personbalance->save();


            $withdraw=Withdraw::create([
                'account_id'=>$account->id,
                 'type'=>$type,
                //ملاحظة ضيف رقم الهوية الى الجدول وممكن بلا
                'user_id'=>$user->id,
                'balance'=>$amount,
                'withdraw_date'=>now(),
            ]);

            DB::commit();


            return response()->json([

                'data'=>$withdraw,
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
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }

    public function withdrawHistory(Request $request){  //للاستفسار عن طريق الموظف
        if (!auth()->user()->tokenCan('user') && !auth()->user()->tokenCan('admin')){

            return response()->json([
                'message'=>'you Dont Have permission'
            ],400);
        }
        $account=Account::where('accountNumber',$request->accountNumber)->first();

        $withdraw=Withdraw::where('account_id',$account->id)->get();

        return response()->json([
            'Accounts'=>$withdraw,
        ],200);
    }
    public function mywithdraw(){ // للاستفسار من حساب الزبون عن حسابه

        $user=Auth::user();
        $account=$user->accounts;
        $withds=Account::with('withdraws')->where('customer_id',$user->id)->get();
        $withdraw="";
        foreach ($withds as $withd)
        {
            $withdraw=$withd->withdraws;
        }
//        $withdraw=Withdraw::whereIn('account_id',$account->pluck('id'))->get();

        return response()->json([
            'Accounts'=>$account,
            '$withdraw'=>$withdraw,
        ],200);
    }
}
