<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        return DB::table('reservations')->paginate($request->get('limit',10));
    }

    public function vacant(ReservationRequest $request){
        return(Room::vacant($request->all()));
    }

    public function get(Reservation $reservation)
    {
        return $reservation;
    }

    public function post(ReservationRequest $request)
    {
        $request->validate(['name'=>'required|string','contact'=>'required|string']);
        $reservation=Reservation::reserve($request->all());

        if(!$reservation){
            return response()->json(null,404);
        }

        return response()->json($reservation,201);
    }

    public function delete(Request $request, Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(null,204);
    }
}
