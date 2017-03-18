<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class EmployeeRights
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $role)
    {
      if (!$this->check($role)) {
          return view('/unauthorized');
      }
      return $next($request);
    }

    private function check($role)
    {
      $check = User::where('id','=', Auth::id())->pluck($role);
      if($check != '0'){
        return true;
      }else{
        return false;
      }
    }
}
