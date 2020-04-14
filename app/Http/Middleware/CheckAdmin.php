<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Classes\Models;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
		if (!Auth::guard('admin')->check()) {
           return redirect('admin_login');
        }
		return $next($request);
    }
}
