<?php

namespace App\Http\Controllers;

use App\Models\Acc_money;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Customer;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
       use HTTP_ResponseTrait;
    public function __construct()
    {
        $this->middleware('isUser');
        //$this->middleware('isAdmin')->only(['store','edit','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account=Account::with(['customer','branch','transachs','withdraws','deposits'])->get();
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
            if ($ifexiest){
                return response()->json([
                   'error'=>'this customer is already have account'
                ],400);
            }
            $account=Account::create([
                'customer_id'=>$customer->id,
                'branch_id'=>$branch->id,
                'accountNumber'=>rand(000001, 999999),
//                'balance'=>$request->balance,
                'openingDate'=>now(),
                'type'=>$request->AccountType,
            ]);

            Acc_money::create([
                    'acc_id'=>$account->id,
                    'money_id'=>1,
            ]);

            Acc_money::create([
                'acc_id'=>$account->id,
                'money_id'=>2,
            ]);
            Acc_money::create([
                'acc_id'=>$account->id,
                'money_id'=>3,
            ]);

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

    public function showaccunt($id){
        $account= Account::with(['accmonies','customer','branch','transachs','withdraws','deposits'])
            ->where('id',$id)->first();
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
}
