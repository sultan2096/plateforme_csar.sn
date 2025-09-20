<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Déterminer l'interface basée sur l'URL
        $path = request()->path();
        
        if (str_contains($path, 'admin')) {
            return view('auth.admin-login');
        } elseif (str_contains($path, 'dg')) {
            return view('auth.dg-login');
        } elseif (str_contains($path, 'responsable') || str_contains($path, 'entrepot')) {
            return view('auth.responsable-login');
        } elseif (str_contains($path, 'agent')) {
            return view('auth.agent-login');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Rediriger selon le rôle
        $user = Auth::user();
        if ($user->role) {
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'dg':
                    return redirect()->intended('/dg/dashboard');
                case 'responsable':
                    return redirect()->intended('/entrepot/dashboard');
                case 'agent':
                    return redirect()->intended('/agent/dashboard');
                default:
                    return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
} 