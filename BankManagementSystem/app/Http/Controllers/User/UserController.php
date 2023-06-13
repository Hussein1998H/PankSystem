<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

class UserController extends Controller
{
    use HTTP_ResponseTrait;

    public function __construct()
    {
        $this->middleware(['isAdmin','auth:sanctum']);
    }

    public function index()
    {
        $users=User::all();
      return $this->returndata(true,$users,200);
    }
    public function edit( $id)
    {
        $user=User::find($id);
        return $this->returndata(true,$user,200);

    }
    public function update(Request $request, $id)
    {
//        $file = $request->file('photo');
//        $name = $file->getClientOriginalName();
//        $image=$request->file('photo')->getClientOriginalName();
//        $imageName=$request->file('photo')->storeAs('user',$image,'images');

        $branch= Branch::where('address',$request->branchaddress)->first();
        $user=User::find($id);
        $user->update([
            'branch_id'=>$branch->id,
            'firstName'=>$request->firstName,
            'lastName'=>$request->lastName,
            'ID_number'=>$request->ID_number,
            'gender'=>$request->gender,
//            'image'=>$imageName,
            'address'=>$request->address,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'role'=>$request->role,
            'password' => Hash::make($request->password)
        ]);
        return $this->returndata(true,$user,200);
    }


    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
       // unlink(public_path('images'.'/'.$user->image));

        return $this->deletedata(true,'Customer deleted successfully',200);

    }

}
