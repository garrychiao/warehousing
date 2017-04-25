<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class SystemController extends Controller
{
    public function __construct()
    {
      $this->middleware('emp_rights:administrator');
    }

    public function systemlog(){

      $systemlogs = DB::table('login_log')->join('users','users.id','=','login_log.user_id')
              ->select('login_log.*','users.name')->orderBy('id','desc')->get();
      $data = compact('systemlogs');

      return view('system/systemlog',$data);
    }
}
