<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use DB;

class EmployeeController extends Controller
{
  public function __construct()
  {
    $this->middleware('emp_rights:administrator');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();
        return view('employee/index')->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $length = count($request->id);
      
      for($i=0 ; $i<$length ; $i++){
        DB::table('users')
            ->where('id', $request->id[$i])
            ->update([
            'administrator' => $request->administrator[$i],
            'inventory' => $request->inventory[$i],
            'purchase' => $request->purchase[$i],
            'customer' => $request->customer[$i],
            'supplier' => $request->supplier[$i],
            'proforma' => $request->proforma[$i],
            'commercial' => $request->commercial[$i],
            'data_export' => $request->data_export[$i]
          ]);
      }

      return redirect('employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
