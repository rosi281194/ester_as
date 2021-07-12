<?php

namespace App\Http\Controllers;

use App\Models\Escuadron;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PersonaController extends Controller
{
    public function getAll()
    {
        $data = Persona::getAll();
        $escuadron = Escuadron::getAll();
        $escuadron = $escuadron->pluck('nombre', 'id');
        return Inertia::render('Persona/tabla', ['personas' => $data,'escuadron'=>$escuadron]);
    }

    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required',
                'apellido' => 'required',
                'ci' => 'required',
                'fechaNacimiento' => 'required',
                'escuadron' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => -1,
                    'errors' => $validator->errors()
                ]);
            }
            $data = new Persona();
            if (!empty($request['id'])) {
                $data = Persona::find($request['id']);
            }
            $data->fill($request->all());
            $data->save();
            return response()->json(["status" => 0, 'path' => 'persona']);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            return response()->json(["status" => -1,
                'error' => $error,], 500);
        }
    }

    public function borrar($id)
    {
        $user = Persona::find($id);
        $user->delete();
        return back()->withInput();
    }
}
