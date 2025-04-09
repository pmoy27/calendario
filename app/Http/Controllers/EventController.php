<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\Tipo;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = FacadesDB::table('events')
            ->join('tipos', 'tipos.id', '=', 'events.tipo_id')
            ->select('events.id', 'events.titulo', 'events.telefono', 'events.fecha_inicio', 'tipos.nombre', 'events.hora_inicio', 'tipos.id as tipo_id')
            ->get();
        $usuario = auth::user()->id;
        $tipo = Tipo::all();
        return view('calendario', compact('event', 'tipo'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $evento =  new Event();
        $evento->titulo = $request->titulo;
        $evento->fecha_inicio = $request->fecha . ' ' . $request->hora;
        $evento->fecha_fin = $request->fecha . ' ' . $request->hora;;
        $evento->tipo_id = $request->tipo_atencion;
        $evento->telefono = $request->telefono;
        $evento->hora_inicio = $request->hora;
        $evento->user_id = auth::user()->id;
        $evento->save();
        return redirect()->back();
    }


    public function checkDisponibilidad(Request $request)
    {
        $fecha = $request->fecha;

        // Consultar las reservas para esa fecha y extraer las horas
        $horariosOcupados = Event::whereDate('fecha_inicio', $fecha)
            ->get()
            ->map(function ($reserva) {
                return date('H:i:s', strtotime($reserva->fecha_inicio));
            })
            ->toArray();

        return response()->json([
            'horariosOcupados' => $horariosOcupados
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $data = $request->json()->all();

            $evento = Event::findOrFail($data['id']);
            $evento->titulo = $data['titulo'];
            $evento->telefono = $data['telefono'];
            $evento->tipo_id = $data['tipo_atencion'];
            $evento->fecha_inicio = $data['fecha'] . ' ' . $data['hora'];
            $evento->hora_inicio = $data['hora'];
            $evento->fecha_fin = $data['fecha'] . ' ' . $data['hora'];
            $evento->user_id = auth::user()->id;
            $evento->save();

            return response()->json([
                'success' => true,
                'message' => 'Evento actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteEvent(Request $request)
    {
        try {
            $evento = Event::findOrFail($request->id);
            $evento->delete();

            return redirect()->route('calendario')->with('success', 'Evento eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('calendario')->with('error', 'Error al eliminar evento: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $evento = Event::findOrFail($id);
            $evento->delete();

            return redirect()->route('calendario')->with('success', 'Evento eliminado correctamente');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
