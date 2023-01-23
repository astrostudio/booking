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
    /**
     * @OA\Get(
     *      path="/reservation",
     *      operationId="reservation-index",
     *      summary="Get list of reserved rooms",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(Request $request)
    {
        return DB::table('reservations')->paginate($request->get('limit',10));
    }

    /**
     * @OA\Get(
     *      path="/reservation/vacant",
     *      operationId="reservation-vacant",
     *      summary="Checks if reservation is possible",
     *      @OA\Parameter(
     *          name="start",
     *          description="Start date of reservation",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="stop",
     *          description="Stop date of reservation",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="days",
     *          description="Number of days",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="beds",
     *          description="Number of beds in room requested",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function vacant(ReservationRequest $request){
        return(Room::vacant($request->all()));
    }

    /**
     * @OA\Get(
     *      path="/reservation/{id}",
     *      operationId="reservation-get",
     *      summary="Gets specific reservation",
     *      @OA\Parameter(
     *          name="id",
     *          description="Room ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          ref="#/components/schemas/Room"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function get(Reservation $reservation)
    {
        return $reservation;
    }

    /**
     * @OA\Post(
     *      path="/reservation",
     *      operationId="reservation-post",
     *      summary="Try and make reservation",
     *      @OA\Parameter(
     *          name="start",
     *          description="Start date",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="stop",
     *          description="Stop date",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="date",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="days",
     *          description="Number of days",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default="1"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="beds",
     *          description="Number of beds",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name of person who reserve",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="contact",
     *          description="Contact information",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          ref="#/components/schemas/Room"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function post(ReservationRequest $request)
    {
        $request->validate(['name'=>'required|string','contact'=>'required|string']);
        $reservation=Reservation::reserve($request->all());

        if(!$reservation){
            return response()->json(null,404);
        }

        return response()->json($reservation,201);
    }

    /**
     * @OA\Delete(
     *      path="/reservation/{id}",
     *      operationId="reservation-delete",
     *      summary="Delete reservation",
     *      @OA\Parameter(
     *          name="id",
     *          description="Reservation ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          ref="#/components/schemas/Room"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function delete(Request $request, Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(null,204);
    }
}
