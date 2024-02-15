<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Traits\HTTP_ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    use HTTP_ResponseTrait;

    public function __construct()
    {
//        $this->middleware('isUser');
        $this->middleware('isCustomer')->only('index');
        $this->middleware('isAdmin')->only(['store','edit','update','destroy']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches=Branch::all();
        return $this->returndata(true,$branches,200);
    }
    public function getBranches()
    {
        $branches=Branch::all();
        return $this->returndata(true,$branches,200);
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
        $validator=Validator::make($request->all(),[
            'address'=>'required',
            'phone'=>'required|digits_between:8,15',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(false, 'validation error', $validator->errors(), 401);
        }
        $branch=Branch::create([
            'address'=>$request->address,
            'phone'=>$request->phone,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Branch Created In Successfully',
            'data'=>$branch,
        ],200);
       // return $this->successResponse(true, 'Branch Created In Successfully', $branch, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return $this->returndata(true,$branch,200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
//        if (!$branch){
//
//            return $this->errorResponse(false,'this branch not found','Branch Not Found',401);
//        }
        return $this->returndata(true,$branch,200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
       $branch->update([
           'address'=>$request->address,
           'phone'=>$request->phone,
       ]);
        return response()->json([
            'status'=>true,
            'message'=>'Branch Created In Successfully',
            'data'=>$branch,
        ],200);
        //return $this->successResponse(true, 'Branch Updated In Successfully', $branch, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return $this->deletedata(true,'Branch deleted successfully',200);

    }
}
