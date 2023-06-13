<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Notifications\ResetPasswordNotificaton;
use App\Traits\HTTP_ResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HTTP_ResponseTrait;
    private $otp;
    public function __construct()
    {
        $this->otp=new Otp;
    }
    public function login(Request $request){

        $validator=Validator::make($request->all(),
            [
                'ID_number'=>'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);
        if ($validator->fails())
        {
            return $this->errorResponse(false, 'validation error', $validator->errors(), 401);
        }

        if (Auth::attempt($request->only(['email', 'password','ID_number']))) {

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token-name',[$user->role])->plainTextToken;

            return $this->successResponse(true, 'User Logged In Successfully', $user, $token, 200);
        }


       elseif (Auth::guard('customer')->attempt($request->only(['email','password','ID_number']))){
           $customer=Customer::where('email',$request->email)->first();
           $token=$customer->createToken('API_Token_For' . $customer->firstName,[$customer->role])->plainTextToken;
           return $this->successResponse(true, 'Customer Logged In Successfully', $customer, $token, 200);
       }


        else{
            return $this->errorResponse(false, 'Email & Password does not match with our record', 'ERROR', 401);

        }
    }
    public function logout(){
        \auth()->user()->tokens()->delete();
        return response()->json([
            'message'=>'Your logout success'
        ],200);
    }
    public function forgetPassword(Request $request){
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
            ]);

        if ($validateUser->fails()){
            return $this->errorResponse(false, 'validation error', $validateUser->errors(), 401);

        }
        $customer=Customer::where('email',$request->email)->first();
        if ($customer){
            $customer->notify(new ResetPasswordNotificaton());

            return response()->json([
                'message'=>'we Send To your Email A code Check IT'
            ]);
        }
        $user=User::where('email',$request->email)->first();
        if ($user) {
            $user->notify(new ResetPasswordNotificaton());

            return response()->json([
                'message' => 'we Send To your Email A code Check IT'
            ]);
        }

    }

    public function resetPassword(Request $request){
        $validateUser = Validator::make($request->all(),
            [
                'password' => 'required|min:6|confirmed',
                'otp' => 'required',
            ]);

        if ($validateUser->fails()){
            return $this->errorResponse(false, 'validation error', $validateUser->errors(), 401);

        }
        $otp2=$this->otp->validate($request->email,$request->otp);

        if (!$otp2->status){
            return response()->json([
                'Error'=>$otp2
            ],401);
        }
        $customer=Customer::where('email',$request->email)->first();
        if ($customer){
            $customer->update([
                'password'=>Hash::make($request->password)
            ]);
            $customer->tokens()->delete();
            return response()->json([
                'success'=>'Password Changed'
            ],200);
        }
        $user=User::where('email',$request->email)->first();

        if ($user){

            $user->update([
                'password'=>Hash::make($request->password)
            ]);
            $user->tokens()->delete();
            return response()->json([
                'success'=>'Password Changed'
            ],200);
        }


    }
}
