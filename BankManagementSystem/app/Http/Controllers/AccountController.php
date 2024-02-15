<?php

namespace App\Http\Controllers;

use App\Models\Acc_money;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\mony;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
       use HTTP_ResponseTrait;
    public function __construct()
    {
        $this->middleware('isUser')->except(['showaccunt']);
        //$this->middleware('isAdmin')->only(['store','edit','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account=Account::with(['customer','accmonies','branch','transachs','withdraws','deposits'])->get();
        return $this->returndata(true,$account,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator=Validator::make($request->all(),[

                'address'=>'required',
                'ID_number'=>'required',
//                'balance'=>'required',

            ]);
            if ($validator->fails()){
                return $this->errorResponse(false, 'validation error', $validator->errors(), 401);

            }
            $customer=Customer::where('ID_number',$request->ID_number)->first();
            $branch=Branch::where('address',$request->address)->first();
            $ifexiest=Account::where('customer_id',$customer->id)->first();
//            if ($ifexiest){
//                return response()->json([
//                   'error'=>'this customer is already have account'
//                ],400);
//            }
            $account=Account::create([
                'customer_id'=>$customer->id,
                'branch_id'=>$branch->id,
                'accountNumber'=>rand(000001, 999999),
//                'balance'=>$request->balance,
                'openingDate'=>now(),
                'type'=>$request->AccountType,
            ]);

            $usd=mony::where('type','USD')->first();
            $tr=mony::where('type','TRY')->first();
            $eur=mony::where('type','EUR')->first();

            if ($request->type_mony=='USD'){
                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$usd->id,
                    'balance'=>$request->balance,
                ]);

                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$tr->id,
                ]);
                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$eur->id,
                ]);

            }
            elseif($request->type_mony=='TRY'){
                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$tr->id,
                    'balance'=>$request->balance,
                ]);

                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$usd->id,

                ]);


                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$eur->id,
                ]);

            }

            elseif($request->type_mony=='EUR'){
                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$usd->id,

                ]);

                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$tr->id,

                ]);
                Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>$eur->id,
                    'balance'=>$request->balance,
                ]);

            }

//            Acc_money::create([
//                    'acc_id'=>$account->id,
//                    'money_id'=>1,
//            ]);
//
//            Acc_money::create([
//                'acc_id'=>$account->id,
//                'money_id'=>2,
//            ]);
//            Acc_money::create([
//                'acc_id'=>$account->id,
//                'money_id'=>3,
//            ]);

            return $this->returndata(true,$account,200);
        }
        catch (\Throwable $th) {
            return $this->errorResponse(false, ' error', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {

//        $account= $account->with(['accmonies','customer','branch','transachs','withdraws','deposits'])->first();
//        return $this->returndata(true,$account,200);
    }

    public function showaccunt(){
        $account= Account::with(['accmonies','branch','transachs','withdraws','deposits'])
            ->whereIn('customer_id',[auth()->id()])->get();
        return $this->returndata(true,$account,200);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return $this->returndata(true,$account,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $customer=Customer::where('ID_number',$request->ID_number)->first();
        $branch=Branch::where('address',$request->address)->first();
        $account->update([
            'customer_id'=>$customer->id,
            'branch_id'=>$branch->id,
            'accountNumber'=>$request->accountNumber,
//            'balance'=>$request->balance,
            'openingDate'=>now(),
            'type'=>$request->AccountType,
        ]);

        return $this->returndata(true,$account,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return $this->deletedata(true,'Account deleted successfully',200);
    }

    public function blockAccount(Request $request){

        $account=Account::where('accountNumber',$request->accountNumber)->first();
        $account->update([
            'isActive'=>false,
        ]);
        return response()->json([
           'status'=>true,
           'message'=>'this Account Was Blocked',
           'data'=>$account
        ],200);
    }

    public function unblockAccount(Request $request){

        $account=Account::where('accountNumber',$request->accountNumber)->first();
        $account->update([
            'isActive'=>true,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'this Account Was Blocked',
            'data'=>$account
        ],200);
    }
}
