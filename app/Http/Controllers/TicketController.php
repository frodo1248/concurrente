<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Jobs\LockedTask;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TicketController extends Controller
{

    var $mensaje = 1;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::get();
        $ticket = Ticket::where('usuario', session('_token'))->where('estado', 'activo')->get();

        return view('welcome', $ticket, ['tickets' => $tickets]);
    }

    
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

   
   
   
   
    /**
     * Store a newly created resource in storage.
     */
   
     public function store()
    {
        // Creo el lock 
        Cache::lock('dame_tiket', 10)->get(function () {
            // Bloqueo adquirido durante 10 segundos y liberado automáticamente...
            // Todo lo contenido en la funcion se realiza atomicamente
            $ticket = new Ticket;
            $ticket->usuario = session('_token');


            dd('entro al lock');


            // Me fijo si ya tiene ticket
            $ticketvalidate = Ticket::where('usuario', session('_token'))->where('estado', 'activo')->get();
            if ($ticketvalidate->isEmpty()) {
                // Guardo en la base el ticket
                $ticket->save();
                // Mensaje de exito
                $this->mensaje=2;                     
            } else {
                // Mensaje de aviso que ya tiene ticket
                $this->mensaje=3;
            }
        });

        // Mensajes de aviso
        if ($this->mensaje==1) {
            return to_route('ticket.show')->with('status', 'Intente nuevamente Por Favor!');
        };
        if ($this->mensaje==2) {
            return to_route('ticket.show')->with('status', 'Ticket Creado!');        
        };
        if ($this->mensaje==3) {
            return to_route('ticket.show')->with('status', 'Ya tiene Ticket!');      
        };

    }



    /**
     * Display the specified resource.
     */
    public function show()
    {
        //Ticket del usuario activo
        $ticket = Ticket::where('usuario', session('_token'))->where('estado', 'activo')->get();

        //Tickets activos
        $tickets = Ticket::where('estado', 'activo')->get();

        //Para no mandar nulo ticket
        if ($ticket->isEmpty()) {
            $ticket = new Ticket;
        } else {
            //$ticket = new Ticket;
            $ticket = $ticket[0];
        }

        return view('welcome', ['ticket' => $ticket], ['tickets' => $tickets]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }



    public function timer($ticket)
    {
        return to_route('ticket.show')->with('status', 'Paso por el timer');
    }
    
    
    
    
    /**
     * Update the specified resource in storage.
     */
    public function update($ticket, $timer)
    {
        Cache::lock('dame_tiket', 10)->get(function () {
            // Bloqueo adquirido durante 10 segundos y liberado automáticamente...
            Ticket::where('usuario', session('_token'))->update(['estado' => 'finalizado']);
        });

        if ($timer == 'no'){
            return to_route('ticket.show')->with('status', 'PASANDO...');

        }
        return to_route('ticket.show')->with('status', 'Han pasado los 10 segundos');
    }

    
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
