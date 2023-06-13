<?php

namespace App\Traits;

trait HTTP_ResponseTrait
{

    public function successResponse($status=true,$message=null,$data=null,$token=null,$code=null){

        return response()->json([
            'status' => $status,
            'message'=>$message,
            'data'=>$data,
            'token'=>$token,
        ],$code);
    }

    public function errorResponse($status=true,$message=null,$error=null,$code=null){

        return response()->json([
            'status' => $status,
            'message'=>$message,
            'error'=>$error,
        ],$code);
    }

    public function returndata($status=true,$data=null,$code=null){

        return response()->json([
            'status' => $status,
            'data'=>$data,
        ],$code);
    }

    public function deletedata($status=true,$message=null,$code=null){

        return response()->json([
            'status' => $status,
            'message'=>$message,
        ],$code);
    }
}
