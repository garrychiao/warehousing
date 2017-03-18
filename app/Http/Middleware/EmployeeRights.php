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
      $permission_check = User::where('id','=', Auth::id())->pluck($role);
      //case occurred on different OS like mac OS or Ubuntu
      //in case of further modification would cause the sam problem
      //below if function will double check
      if($permission_check == '[1]' || $permission_check == '["1"]'){
        return true;
      }else{
        return false;
      }
    }
}
