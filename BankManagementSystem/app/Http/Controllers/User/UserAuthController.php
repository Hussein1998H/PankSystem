<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Notifications\ResetPasswordNotificaton;
use App\Traits\HTTP_ResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
//    private $otp;
//    public function __construct()
//    {
//        $this->otp=new Otp;
//    }

    use HTTP_ResponseTrait;
    public function __construct()
    {
        $this->middleware('isUser');
        $this->middleware('isAdmin')->only('createUser');

    }

    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                     'firstName'=> 'required',
                     'lastName'=> 'required',
                     'ID_number'=>'required|digits_between:8,20',
                     'address'=> 'required',
                     'email'=> 'required|email|unique:users,email',
                     'phone'=> 'required|digits_between:8,15',
                     'password'=> 'required|min:8',
                ]);

            if($validateUser->fails()){

                return $this->errorResponse(false, 'validation error', $validateUser->errors(), 401);
            }
//            $image=$request->file('photo')->getClientOriginalName();
//            $imageName=$request->file('photo')->storeAs('user',$image,'images');

           $branch= Branch::where('address',$request->branchaddress)->first();
            $user = User::create([
                'branch_id'=>$branch->id,
                'firstName'=>$request->firstName,
                'lastName'=>$request->lastName,
                'ID_number'=>$request->ID_number,
                'gender'=>$request->gender,
//                'image'=>$imageName,
                'address'=>$request->address,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'role'=>$request->role,
                'DateOfHiring'=>now(),
                'email_verified_at'=>now(),
                'phone_verified_at'=>now(),
                'password' => Hash::make($request->password)
            ]);


            $token=$user->createToken("API_TOKEN_For".$user->firstName,[$user->role])->plainTextToken;

            return $this->successResponse(true, 'User Created In Successfully', $user, $token, 200);

        } catch (\Throwable $th) {
            return $this->errorResponse(false, ' error', $th->getMessage(), 500);
        }
    }

    public function profile(){

        $user=\auth()->user();
        return response()->json([
            'data'=>$user,
        ],200);
    }
//    public function loginUser(Request $request)
//    {
//        try {
//            $validateUser = Validator::make($request->all(),
//                [
//                    'email' => 'required|email',
//                    'password' => 'required',
//                    'ID_number'=>'required',
//                ]);
//
//            if ($validateUser->fails()) {
//                return $this->errorResponse(false, 'validation error', $validateUser->errors(), 401);
//            }
//
//            if (!Auth::attempt($request->only(['email', 'password','ID_number']))) {
//
//                return $this->errorResponse(false, 'Email & Password does not match with our record', 'ERROR', 401);
//            }
//
//            $user = User::where('email', $request->email)->first();
//            $token = $user->createToken('token-name',[$user->role])->plainTextToken;
//
//            return $this->successResponse(true, 'User Logged In Successfully', $user, $token, 200);
//        }
//        catch (\Throwable $th){
//            return $this->errorResponse(false, ' error', $th->getMessage(), 500);
//        }
//
//    }
//
//    public function logout(Request $request){
//
//        \auth()->user()->tokens()->delete();
//        return response()->json([
//            'message'=>'Your logout success'
//        ],200);
//    }
//
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
//        $user=User::where('email',$request->email)->first();
//        $user->notify(new ResetPasswordNotificaton());
//
//        return response()->json([
//            'message'=>'we Send To your Email A code Check IT'
//        ]);
//    }
//
//    public function resetPassword(Request $request){
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
//        $user=User::where('email',$request->email)->first();
//
//        $user->update([
//            'password'=>Hash::make($request->password)
//        ]);
//        $user->tokens()->delete();
//        return response()->json([
//            'success'=>'Password Changed'
//        ],200);
//    }
}
