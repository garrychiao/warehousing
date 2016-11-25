<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Http\Requests;

class EMSController extends Controller
{
    public function index(){

      $customer = Customer::get();
      return view('ems/index')->with('customer',$customer);
    }
}
