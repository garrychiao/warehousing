<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::select('name')->where('id', Auth::user()->id)->first();
        $geo_info = geoip()->getLocation();

        $data = compact(
            'user',
            'geo_info'
          );

        return view('home', $data);
    }
}
