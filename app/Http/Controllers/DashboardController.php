<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Escuadron;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function index()
    {
        $nowI = Carbon::now()->startOfDay()->toDateTimeString();
        $nowF = Carbon::now()->endOfDay()->toDateTimeString();
        $presentes = DB::table(Asistencia::$tables)
            ->whereBetween('asistencia.created_at', [$nowI, $nowF])
            ->select('persona')
            ->get()
            ->pluck('persona');
        $personas = DB::table(Persona::$tables)
            ->whereNotIn('id', $presentes)
            ->select(Persona::$tables . '.*')
            ->get();
        $escuadrones = Escuadron::getAll();
        return Inertia::render('Index', ['personas' => $personas, 'escuadrones' => $escuadrones]);
    }

    function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => -1,
                    'errors' => $validator->errors()
                ]);
            }
            $data = new Asistencia();
            $data->persona = $request['id'];
            $data->user = Auth::id();
            $data->save();
            return response()->json(["status" => 0, 'path' => '/']);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            return response()->json(["status" => -1,
                'error' => $error,], 500);
        }
    }
}
