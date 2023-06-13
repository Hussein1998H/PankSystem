<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Notifications\ResetPasswordNotificaton;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    use HTTP_ResponseTrait;


    public function createcustomer(Request $request){
        try {

            $validator = Validator::make($request->all(),
                [
                    'firstName' => 'required',
                    'lastName' => 'required',
                    'ID_number'=>'required|digits_between:8,20',
                    'address' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|digits_between:8,15',
                    'password' => 'required|min:8',
                ]);
            if ($validator->fails()) {
                return $this->errorResponse(false, 'validation error', $validator->errors(), 401);

            }
//            $image=$request->file('photo')->getClientOriginalName();
//            $imageName=$request->file('photo')->storeAs('customer',$image,'images');

            $customer = Customer::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'ID_number'=>$request->ID_number,
                'gender' => $request->gender,
//                'image'=>$imageName,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'DateOfHiring' => now(),
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'password' => Hash::make($request->password)
            ]);
            $token = $customer->createToken('API_Token_For' . $customer->firstName,[$customer->role])->plainTextToken;
            return $this->successResponse(true, 'Customer Created In Successfully', $customer, $token, 200);
        }
          catch (\Throwable $th) {
                return $this->errorResponse(false, ' error', $th->getMessage(), 500);
        }
    }


//    public function customerlogin(Request $request){
//
//        try {
//            $validator=Validator::make($request->all(),
//                [
//                    'ID_number'=>'required',
//                    'email' => 'required|email',
//                    'password' => 'required'
//                ]);
//            if ($validator->fails())
//            {
//                return $this->errorResponse(false, 'validation error', $validator->errors(), 401);
//            }
//            if (!Auth::guard('customer')->attempt($request->only(['email','password','ID_number']))){
//                return $this->errorResponse(false, 'Email & Password does not match with our record', 'ERROR', 401);
//
//            }
//            $customer=Customer::where('email',$request->email)->first();
//            $token=$customer->createToken('API_Token_For' . $customer->firstName,[$customer->role])->plainTextToken;
//            return $this->successResponse(true, 'Customer Logged In Successfully', $customer, $token, 200);
//        }
//        catch (\Throwable $th) {
//            return $this->errorResponse(false, ' error', $th->getMessage(), 500);
//        }
//    }
    public function customerprofile(){
        $customer=\auth()->user();
        return response()->json([
            'data'=>$customer,
        ],200);
    }
//    public function customerlogout(){
//        \auth()->user()->tokens()->delete();
//        return response()->json([
//            'message'=>'Your logout success'
//        ],200);
//    }


    public function update(Request $request, Customer $customer)
    {
//        $file = $request->file('photo');
//        $name = $file->getClientOriginalName();


//        $image=$request->file('photo')->getClientOriginalName();
//
//        $imageName=$request->file('photo')->storeAs('customer',$image,'images');
        $customer->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'ID_number'=>$request->ID_number,
            'gender' => $request->gender,
//            'image'=>$imageName,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);
        return $this->returndata(true,$customer,200);
    }

//    public function forgetPassword(Request $request){
//        $validateUser = Validator::make($request->all(),
//            [
//                'email' => 'required|email',
//            ]);
//
//        if ($validateUser->fails()){
//            return $this->errorResponse(false, 'validation error', $validateUser->errors(), 401);
//
//        }
//        $customer=Customer::where('email',$request->email)->first();
//        $customer->notify(new ResetPasswordNotificaton());
//
//        return response()->json([
//            'message'=>'we Send To your Email A code Check IT'
//        ]);
//    }
//
//    public function resetPassword(Request $request){
//
//        $validateUser = Validator::make($request->all(),
//            [
//                'password' => 'required|min:6|confirmed',
//                'otp' => 'required',
//            ]);
//
//        if ($validateUser->fails()){
//            return $this->errorResponse(false, 'validation error', $validateUser->errors(), 401);
//
//        }
//        $otp2=$this->otp->validate($request->email,$request->otp);
//
//        if (!$otp2->status){
//            return response()->json([
//                'Error'=>$otp2
//            ],401);
//        }
//        $customer=Customer::where('email',$request->email)->first();
//
//        $customer->update([
//            'password'=>Hash::make($request->password)
//        ]);
//        $customer->tokens()->delete();
//        return response()->json([
//            'success'=>'Password Changed'
//        ],200);
//    }
}
