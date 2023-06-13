<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
