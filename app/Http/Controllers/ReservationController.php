<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Reservation;

class ReservationController extends Controller
{
    public function index()
    {

        try {
            $reservations = Reservation::query()->with(['user', 'ticket'])->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

        return response()->json(['results' => count($reservations), 'reservations' => $reservations], 200);
    }

    public function userReservation($id)
    {
        try {
            $reservations = Reservation::where('user_id', $id)->with(['user', 'ticket'])->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

        return response()->json(['results' => count($reservations), 'reservations' => $reservations], 200);
    }

    public function register(Request $request)
    {

        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:App\User,id',
                'ticket_id' => [
                    'required',
                    Rule::exists('tickets', 'id')->where(function ($query) {
                        $query->where('quantity', '>', 0);
                    }),
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'La información recibida no es valida.', 'errors' => $validator->errors()], 400);
            } else {
                $ticket = \App\Ticket::where('id', $request->ticket_id)->first();
                $ticket->quantity += -1;
                $ticket->save();
            }

            $reservation = Reservation::create(array_merge(
                $validator->validated()
            ));

            DB::commit();

            return response()->json([
                'message' => 'Su boleta a sido reservada correctamente.',
                'reservation' => $reservation
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
