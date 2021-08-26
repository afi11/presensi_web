<?php

namespace App\Http\Middleware;

use Closure;

class SudahLogin
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
            return redirect("/"); 
        }
        return $next($request);
    }
}
