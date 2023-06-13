<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositsController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user=Auth::user();
            $account=Account::where('accountNumber',$request->accountNumber)->first();
            $amount=$request->amount;
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


            $account->balance +=$amount;


            $account->save();


            $deposit=Deposit::create([
                'account_id'=>$account->id,
                //ملاحظة ضيف رقم الهوية الى الجدول وممكن بلا
                'user_id'=>$user->id,
                'balance'=>$amount,
                'withdraw_date'=>now(),
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
}
