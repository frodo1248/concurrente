<x-layouts.app title="Home" meta-description="Home meta description">


    <div class="container">
        <div class="row text-center">

            {{-- Tabla que indica los tickets activos --}}
            <div class="col-8 py-5">
                <p class="alert alert-info">Orden de Tickets</p>
                <table class="table table-primary">

                    {{-- <thead>
                        <tr>
                            <th>{{ $item->id }}</th>
                        </tr>
                    </thead> --}}
                    @if (!$tickets->isEmpty())
                        @foreach ($tickets as $item)
                            <tbody>
                                <tr>
                                    <td>{{ $item->id }}</td>
                                </tr>
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>


            <div class="col-4 py-5">
                {{-- Boton para dar ticket a un usuario --}}
                <div>
                    @if ($ticket->estado != 'activo')
                        <button onclick="deshabilitarBoton(this)" class="btn btn-lg btn-primary">Quiero Pasar</button>
                        <script>
                            function deshabilitarBoton(boton) {
                                boton.disabled = true;
                                window.location = '{{ route('ticket.store') }}';
                            }
                        </script>
                    @endif
                </div>
                {{-- Cartel con el numero de ticket del usuario --}}
                <div class="py-4">
                    <h3 class="alert alert-info">{{ $ticket->id ? "$ticket->id" : 'Nro Ticket' }}</h3>
                </div>
            </div>

            {{-- Boton para pasar --}}
            <div class="col-12 py-4">
                @if (!$tickets->isEmpty())
                    @if ($tickets[0]->id == $ticket->id and $ticket->estado == 'activo')
                        {{-- {{ route('ticket.timer', $ticket->id ? $ticket->id : '0') }} --}}
                        {{-- @php
                            app('App\Http\Controllers\TicketController')->timer($ticket->id ? $ticket->id : '0');
                        @endphp --}}

                        <div>
                            <h1>Es tu Turno!!!</h1>
                            <h3>Tienes 10 segundos para pasar</h3>
                        </div>


                        <script>
                            let contador;

                            function contarDiezSegundos() {
                                let segundos = 0;
                                contador = setInterval(function() {
                                    segundos++;
                                    console.log(segundos + " segundos han pasado.");
                                    if (segundos === 10) {
                                        clearInterval(contador); // Detiene el contador después de 10 segundos
                                        console.log("¡Han pasado 10 segundos!");
                                        window.location =
                                            '{{ route('ticket.update', ['ticket' => $ticket->id ? $ticket->id : '0', 'timer' => 'si']) }}';
                                    };
                                }, 1000); // Llama a la función cada segundo (1000 milisegundos)
                            }
                            contarDiezSegundos();
                        </script>

                        <button {{-- onclick="window.location='{{ route('ticket.update', $ticket->id ? $ticket->id : '0') }}'" --}}
                            onclick="window.location='{{ route('ticket.update', ['ticket' => $ticket->id ? $ticket->id : '0', 'timer' => 'no']) }}'";
                            class="btn btn-lg btn-warning">Click
                            Aquí para Pasar
                        </button>
                    @endif
                @endif
            </div>
        </div>
        {{-- Funcion para refrescar la pagina --}}
    </div>


</x-layouts.app>
