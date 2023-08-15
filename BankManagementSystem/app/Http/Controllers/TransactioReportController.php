<?php

namespace App\Http\Controllers;

use App\Models\TransactioReport;
use Illuminate\Http\Request;

class TransactioReportController extends Controller
{
    public function index(){

        $report=TransactioReport::all();

        return response()->json([
           'data'=>$report
        ]);
    }
}
