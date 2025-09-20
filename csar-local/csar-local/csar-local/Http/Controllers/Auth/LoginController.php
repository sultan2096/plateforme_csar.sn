<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        // Déterminer l'interface demandée
        $interface = $this->getInterfaceFromRequest($request);
        
        return view('auth.login', compact('interface'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $interface = $request->input('interface', 'admin');
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Vérifier que l'utilisateur a le bon rôle pour cette interface
            if ($this->canAccessInterface($user, $interface)) {
                // Créer une session spécifique pour cette interface
                $this->createInterfaceSession($user, $interface);
                
                $request->session()->regenerate();
                
                // Rediriger vers l'interface appropriée
                return $this->redirectToInterface($interface);
            } else {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['Vous n\'avez pas les permissions pour accéder à cette interface.'],
                ]);
            }
        }
        
        throw ValidationException::withMessages([
            'email' => ['Les identifiants fournis ne correspondent pas à nos enregistrements.'],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $interface = $this->getInterfaceFromRequest($request);
        
        // Nettoyer la session de cette interface
        $this->clearInterfaceSession($interface);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie de l\'interface ' . ucfirst($interface));
    }

    /**
     * Déterminer l'interface à partir de la requête
     */
    private function getInterfaceFromRequest(Request $request): string
    {
        $path = $request->path();
        
        if (str_starts_with($path, 'admin')) {
            return 'admin';
        } elseif (str_starts_with($path, 'dg')) {
            return 'dg';
        } elseif (str_starts_with($path, 'responsable') || str_starts_with($path, 'entrepot')) {
            return 'responsable';
        } elseif (str_starts_with($path, 'agent')) {
            return 'agent';
        } else {
            return 'admin'; // Interface par défaut
        }
    }

    /**
     * Vérifier si l'utilisateur peut accéder à l'interface
     */
    private function canAccessInterface($user, string $interface): bool
    {
        $allowedRoles = match($interface) {
            'admin' => ['admin'],
            'dg' => ['dg', 'admin'],
            'responsable' => ['responsable', 'admin'],
            'agent' => ['agent', 'admin'],
            default => ['admin', 'dg', 'responsable', 'agent']
        };
        
        return in_array($user->role, $allowedRoles);
    }

    /**
     * Créer une session spécifique pour l'interface
     */
    private function createInterfaceSession($user, string $interface): void
    {
        $sessionKey = 'csar_' . $interface . '_session';
        Session::put($sessionKey, [
            'user_id' => $user->id,
            'interface' => $interface,
            'logged_in_at' => now(),
        ]);
    }

    /**
     * Nettoyer la session d'une interface
     */
    private function clearInterfaceSession(string $interface): void
    {
        $sessionKey = 'csar_' . $interface . '_session';
        Session::forget($sessionKey);
    }

    /**
     * Rediriger vers l'interface appropriée
     */
    private function redirectToInterface(string $interface): \Illuminate\Http\RedirectResponse
    {
        return match($interface) {
            'admin' => redirect()->route('admin.dashboard'),
            'dg' => redirect()->route('dg.dashboard'),
            'responsable' => redirect()->route('responsable.dashboard'),
            'agent' => redirect()->route('agent.dashboard'),
            default => redirect()->route('admin.dashboard')
        };
    }
}
