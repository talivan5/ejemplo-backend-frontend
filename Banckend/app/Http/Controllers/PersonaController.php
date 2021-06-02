<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use App\Http\Resources\PersonaResource;
use App\Http\Requests\PersonaRequest;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::query()->orderBy('id','desc')->paginate(5);
        return PersonaResource::collection($personas, Response::HTTP_OK);
    }

    public function store(PersonaRequest $request)
    {
        try {
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellidoPaterno = $request->apellidoPaterno;
            $persona->apellidoMaterno = $request->apellidoMaterno;
            $persona->ci = $request->ci;
            $persona->sexo = $request->sexo;
            $persona->save();
            return response()->json([
                'mensaje' => 'El registro persona se guardo exitosamente',
                'persona' => new PersonaResource($persona)
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            response()->json([
                'mensaje' => 'Error al guardar, consulte con el Administrador' . $e
            ], Response::HTTP_FORBIDDEN);
        }           
    }

    public function show($id)
    {
        $persona= Persona::findOrFail((int) $id);
        return response()->json([
            'persona'=> new PersonaResource($persona)
        ], Response::HTTP_OK);
    }

    public function update(PersonaRequest $request, $id)
    {
        try {
            $persona = Persona::findOrFail((int) $id);
            $persona->nombre = $request->nombre;
            $persona->apellidoPaterno = $request->apellidoPaterno;
            $persona->apellidoMaterno = $request->apellidoMaterno;
            $persona->ci = $request->ci;
            $persona->sexo = $request->sexo;
            $persona->save();
            return response()->json([
                'mensaje' => 'El regitro persona se actualizo exitosamente',
                'persona' => new PersonaResource($persona)
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            response()->json([
                'mensaje' => 'Error al actualizar, consulte con el Administrador' . $e
            ], Response::HTTP_FORBIDDEN);
        }
    }

    public function destroy($id)
    {
        $persona= Persona::findOrFail((int) $id);
        $persona->delete();
        return response()->json([
            'mensaje'=>'El registro fue eliminado'
        ], Response::HTTP_OK);
    }
}
