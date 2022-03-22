<?php

namespace App\Http\Controllers;

use App\Models\Recaudacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RecaudacionController extends Controller
{
    public function getAll()
    {
        $data = Recaudacion::getAll();
        return Inertia::render('Recaudacion/tabla', ['escuadron' => $data]);
    }

    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => -1,
                    'errors' => $validator->errors()
                ]);
            }
            $data = new Recaudacion();

            $data->fill($request->all());
            $data->save();
            return response()->json(["status" => 0, 'path' => 'recaudacion']);
        } catch (\Exception $error) {
            Log::error($error->getMessage());
            return response()->json(["status" => -1,
                'error' => $error,], 500);
        }
    }

    public function borrar($id)
    {
        $user = Escuadron::find($id);
        $user->delete();
        return back()->withInput();
    }
}
