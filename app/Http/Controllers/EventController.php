<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('calendario');
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
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
