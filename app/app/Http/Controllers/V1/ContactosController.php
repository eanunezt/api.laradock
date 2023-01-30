<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ContactosController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo
            //almacenamos en una variable, nosotros no lo utilizaremos.
            $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Listamos todos los Contactoos
        return Contacto::get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre', 'correo', 'telefono', 'direccion',
        'observacion', 'municipioResidencia', 'departamentoResidencia',
        'estado', 'nomReferencia', 'codReferencia');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:100|string',
            'telefono' => 'required|max:100|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el Contactoo en la BD
        $Contacto = Contacto::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'observacion' => $request->observacion,
            'municipioResidencia' => $request->municipioResidencia,
            'departamentoResidencia' => $request->departamentoResidencia,
            'estado' => $request->estado,
            'nomReferencia' => $request->nomReferencia,
            'codReferencia' => $request->codReferencia,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Contacto created',
            'data' => $Contacto
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contacto  $Contacto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el Contactoo
        $Contacto = Contacto::find($id);
        //Si el Contactoo no existe devolvemos error no encontrado
        if (!$Contacto) {
            return response()->json([
                'message' => 'Contacto not found.'
            ], 404);
        }
        //Si hay Contactoo lo devolvemos
        return $Contacto;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacto  $Contacto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only('nombre', 'correo', 'telefono', 'direccion',
        'observacion', 'municipioResidencia', 'departamentoResidencia',
        'estado', 'nomReferencia', 'codReferencia');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:100|string',
            'telefono' => 'required|max:100|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el Contactoo
        $Contacto = Contacto::findOrfail($id);
        //Actualizamos el Contactoo.
        $Contacto->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'observacion' => $request->observacion,
            'municipioResidencia' => $request->municipioResidencia,
            'departamentoResidencia' => $request->departamentoResidencia,
            'estado' => $request->estado,
            'nomReferencia' => $request->nomReferencia,
            'codReferencia' => $request->codReferencia,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Contacto updated successfully',
            'data' => $Contacto
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacto  $Contacto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el Contactoo
        $Contacto = Contacto::findOrfail($id);
        //Eliminamos el Contactoo
        $Contacto->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Contacto deleted successfully'
        ], Response::HTTP_OK);
    }
}
