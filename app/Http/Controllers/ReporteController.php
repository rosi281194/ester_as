<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Escuadron;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReporteController extends Controller
{
    function index()
    {
//        $nowI = Carbon::now()->startOfDay()->toDateTimeString();
//        $nowF = Carbon::now()->endOfDay()->toDateTimeString();
        $presentes = DB::table(Asistencia::$tables)
//            ->whereBetween('created_at', [$nowI, $nowF])
            ->select('persona', DB::raw('count(*) as total'))
            ->groupBy('persona')
            ->get();
        $personas = DB::table(Persona::$tables)
            ->get();

        $cantidadesc = DB::table('persona')
            ->join('asistencia', 'persona.id', '=', 'asistencia.persona')
            ->join('escuadron', 'escuadron.id', '=', 'persona.escuadron')
            ->select('escuadron.nombre as escuadronNombre', DB::raw('count(escuadron.nombre) as total'))
            ->groupBy('escuadron.nombre')
            ->get();

        foreach ($personas as $key => $persona) {
            foreach ($presentes as $presente) {
                if ($persona->id === $presente->persona) {
                    $personas[$key]->total = $presente->total;
                }
            }
        }
        $escuadrones = Escuadron::getAll();
        return Inertia::render('Reporte', ['personas' => $personas, 'escuadrones' => $escuadrones,'cantidad' => $cantidadesc]);
    }

}
