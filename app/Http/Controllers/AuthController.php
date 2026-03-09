<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Rubro;
use App\Models\SubscriptionPlan;
use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $rubros = Rubro::orderBy('nombre')->get();
        $planes = SubscriptionPlan::where('activo', true)->orderBy('precio_mensual')->get();

        return view('auth.register', compact('rubros', 'planes'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'negocio_nombre' => ['required', 'string', 'max:255'],
            'negocio_telefono' => ['nullable', 'string', 'max:50'],
            'rubro_id' => ['required', 'exists:rubros,id'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'plan' => ['required', 'exists:subscription_plans,slug'],
            'terminos' => ['accepted'],
        ]);

        $plan = SubscriptionPlan::where('slug', $data['plan'])->where('activo', true)->firstOrFail();

        $user = DB::transaction(function () use ($data, $plan) {
            $user = User::create([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'telefono' => $data['telefono'] ?? null,
                'password' => Hash::make($data['password']),
                'rol' => 'dueno',
            ]);

            $slugBase = Str::slug($data['negocio_nombre']);
            $slug = $slugBase;
            $counter = 1;
            while (Negocio::where('slug', $slug)->exists()) {
                $slug = $slugBase.'-'.$counter++;
            }

            $negocio = Negocio::create([
                'usuario_id' => $user->id,
                'rubro_id' => $data['rubro_id'],
                'nombre' => $data['negocio_nombre'],
                'telefono' => $data['negocio_telefono'] ?? null,
                'ciudad' => $data['ciudad'] ?? null,
                'slug' => $slug,
                'timezone' => 'America/Argentina/Buenos_Aires',
                'trial_ends_at' => $plan->slug === 'trial'
                    ? now()->addDays((int) env('TRIAL_DAYS', 7))
                    : null,
            ]);

            Suscripcion::create([
                'negocio_id' => $negocio->id,
                'subscription_plan_id' => $plan->id,
                'plan' => $plan->slug,
                'fecha_inicio' => now()->toDateString(),
                'estado' => 'activa',
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', '¡Bienvenido a Tuservice!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no son válidas.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
