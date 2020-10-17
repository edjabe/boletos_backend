<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{
    public function index()
    {

        try {
            $tickets = Ticket::where('quantity', '>', 0)->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

        return response()->json(['results' => count($tickets), 'tickets' => $tickets], 200);
    }
}
