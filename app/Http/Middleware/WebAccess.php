<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\AppAuthTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAccess
{
    use AppAuthTrait;

    protected $except = [
        'user/login',
        'user/signup',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$this->authAttempt($user)) {
            $this->logoutUser();
            return redirect()
                ->route('user.login')
                ->with('error', __('auth.session_expired'));
        }

        if (!$user->is_active) {
            return redirect()->route('user.logout');
        }

        return $next($request);
    }
}
