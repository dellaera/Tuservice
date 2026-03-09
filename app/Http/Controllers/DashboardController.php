<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Turno;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $negocio = Negocio::with(['profesionales', 'servicios', 'clientes'])
            ->where('usuario_id', $user->id)
            ->first();

        $turnosQuery = Turno::query();

        if ($negocio) {
            $turnosQuery->where('negocio_id', $negocio->id);
        } else {
            $turnosQuery->where('negocio_id', 0);
        }

        $hoy = now()->format('Y-m-d');

        $stats = [
            'total_turnos' => (clone $turnosQuery)->count(),
            'turnos_hoy' => (clone $turnosQuery)->where('fecha', $hoy)->count(),
            'clientes' => $negocio?->clientes->count() ?? 0,
            'profesionales' => $negocio?->profesionales->count() ?? 0,
            'servicios' => $negocio?->servicios->count() ?? 0,
        ];

        $proximosTurnos = (clone $turnosQuery)
            ->whereDate('fecha', '>=', $hoy)
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->with(['cliente', 'servicio', 'profesional'])
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('user', 'negocio', 'stats', 'proximosTurnos'));
    }
}
