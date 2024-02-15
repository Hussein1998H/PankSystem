<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class CustomerController extends Controller
{
    use HTTP_ResponseTrait;

    public function __construct()
    {
        $this->middleware('isUser');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $customer=Customer::all();
    return $this->returndata(true,$customer,200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return $this->returndata(true,$customer,200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
//        $file = $request->file('photo');
//        $name = $file->getClientOriginalName();
//        $image=$request->file('photo')->getClientOriginalName();
//
//        $imageName=$request->file('photo')->storeAs('customer',$image,'images');


        $validator = Validator::make($request->all(),
            [
                'firstName' => 'nullable|sometimes',
                'lastName' => 'nullable|sometimes',
                'ID_number'=>'nullable|digits_between:8,20|sometimes',
                'address' => 'nullable|sometimes',
                'email' => 'nullable|email|sometimes',
                'phone' => 'nullable|digits_between:8,15|sometimes',
                'password' => 'nullable|min:8|sometimes',
            ]);
        if ($validator->fails()) {
            return $this->errorResponse(false, 'validation error', $validator->errors(), 401);

        }
        $pasword=$request->password;

        if ($pasword){

            $customer->update([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'ID_number'=>$request->input('ID_number'),
                'gender' => $request->input('gender'),
//            'image'=>$imageName,
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password'))
            ]);
            return $this->returndata(true,$customer,200);
        }
        else{
            $customer->update([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'ID_number'=>$request->input('ID_number'),
                'gender' => $request->input('gender'),
//            'image'=>$imageName,
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);
            return $this->returndata(true,$customer,200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
      //  unlink(public_path('images'.'/'.$customer->image));

        return $this->deletedata(true,'Customer deleted successfully',200);

    }
}
