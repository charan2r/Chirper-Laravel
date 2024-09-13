<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view(view: 'auth.login');
    }
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_admin) {
            return Redirect::intended(default: '/admin');
        }

        return Redirect::intended(default: '/dashboard'); // Or wherever regular users are redirected
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(default: RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard(name: 'web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(to: '/');
    }
}
