<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use DB;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username = 'name';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      $count = User::count();
      if($count == 0){
        $administrator = true;
        $inventory = true;
        $customer = true;
        $supplier = true;
        $proforma = true;
        $commercial = true;
        $purchase = true;
        $data_export = true;
      }else{
        $administrator = false;
        $inventory = false;
        $customer = false;
        $supplier = false;
        $proforma = false;
        $commercial = false;
        $purchase = false;
        $data_export = false;
      }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'administrator' => $administrator,
            'inventory' => $inventory,
            'supplier' => $supplier,
            'customer' => $customer,
            'proforma' => $proforma,
            'commercial' => $commercial,
            'purchase' => $purchase,
            'data_export' => $data_export,
        ]);
    }
    //record if login authenticated
    protected function authenticated()
    {
      DB::table('login_log')->insert([
        'user_id' => Auth::user()->id,
        'login_status' => 1,
        'ip' => geoip()->getLocation()->ip,
        'iso_code' => geoip()->getLocation()->iso_code,
        'country' => geoip()->getLocation()->country,
        'city' => geoip()->getLocation()->city,
        'state' => geoip()->getLocation()->state,
        'state_name' => geoip()->getLocation()->state_name,
        'postal_code' => geoip()->getLocation()->postal_code,
        'lat' => geoip()->getLocation()->lat,
        'lon' => geoip()->getLocation()->lon,
        'timezone' => geoip()->getLocation()->timezone,
        'continent' => geoip()->getLocation()->continent,
        'currency' => geoip()->getLocation()->currency,
        'dateTime' => date("Y-m-d H:i:s")
      ]);

      return redirect('/home');
    }
}
