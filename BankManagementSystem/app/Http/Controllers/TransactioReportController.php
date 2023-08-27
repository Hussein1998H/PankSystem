<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\TransactioReport;
use App\Models\User;
use Illuminate\Http\Request;

class TransactioReportController extends Controller
{
    public function index(){

        $report=TransactioReport::all();

        return response()->json([
           'data'=>$report
        ]);
    }

    public  function reportCount(){

        $customer=Customer::count();
        $branch=Branch::count();
        $account=Account::count();
        $employee=User::count();


        return response()->json([
            'CustomerCount'=>$customer,
            'BranchCount'=>$branch,
            'AccountsCount'=>$account,
            'EmployeeCount'=>$employee,
        ]);
    }
}
