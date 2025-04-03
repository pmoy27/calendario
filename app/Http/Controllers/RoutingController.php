<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tipo;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class RoutingController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    /**
     * Display a view based on first route param
     *
     * @return \Illuminate\Http\Response
     */
    public function root(Request $request, $first)
    {

        $event = FacadesDB::table('events')
            ->join('tipos', 'tipos.id', '=', 'events.tipo_id')
            ->select('events.id', 'events.titulo', 'events.telefono', 'events.fecha_inicio', 'tipos.nombre', 'events.hora_inicio', 'tipos.id')
            ->get();

        $tipo = Tipo::all();
        return view($first, compact('event', 'tipo'));
    }

    /**
     * second level route
     */
    public function secondLevel(Request $request, $first, $second)
    {
        return view($first . '.' . $second);
    }
}
