<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRoleController extends Controller
{
    use HTTP_ResponseTrait;
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
}
