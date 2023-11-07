<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Cache;

// class CheckLock
// {
//     public function handle($request, Closure $next)
//     {
//         $lockKey = 'mi_lock';

//         if (Cache::has($lockKey)) {
//             return to_route('ticket.show')->with('status', 'Ticket Fallo!2'); // Puedes crear una vista específica para mostrar el mensaje de error
//         }

//         return $next($request);
//     }
// }

