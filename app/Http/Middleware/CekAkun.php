<?php

namespace App\Http\Middleware;

use Closure;

class CekAkun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(getTipeAkun() == "adm" && cekUserExist()){
            return $next($request);   
        }
        return redirect("login");
    }
}
