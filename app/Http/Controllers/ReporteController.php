<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Escuadron;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;

class ReporteController extends Controller
{
    function index()
    {
//        $nowI = Carbon::now()->startOfDay()->toDateTimeString();
//        $nowF = Carbon::now()->endOfDay()->toDateTimeString();
        $date = Carbon::now();
        $presentes = DB::table(Asistencia::$tables)
//            ->whereBetween('created_at', [$nowI, $nowF])
            ->select('persona', DB::raw('count(*) as total'))
            ->groupBy('persona')
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->get();
        $personas = DB::table(Persona::$tables)
            ->get();

        $cantidadesc = DB::table('persona')
            ->join('asistencia', 'persona.id', '=', 'asistencia.persona')
            ->join('escuadron', 'escuadron.id', '=', 'persona.escuadron')
            ->select('escuadron.nombre as escuadronNombre', DB::raw('count(escuadron.nombre) as total'))
            ->whereDate('asistencia.created_at', Carbon::now()->toDateString())
            ->groupBy('escuadron.nombre')
            ->get();


        $nuevos = DB::table('persona')
            ->where('estado', '=', 0)
            ->select('*',DB::raw('YEAR(CURDATE())-YEAR(`persona`.`fechaNacimiento`) as Edad') )

            ->get();

        foreach ($personas as $key => $persona) {
            foreach ($presentes as $presente) {
                if ($persona->id === $presente->persona) {
                    $personas[$key]->total = $presente->total;
                }
            }
        }
        $escuadrones = Escuadron::getAll();
        return Inertia::render('Reporte', ['personas' => $personas, 'escuadrones' => $escuadrones,'cantidad' => $cantidadesc,'nuevos' => $nuevos]);
    }

}
