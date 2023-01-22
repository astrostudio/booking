<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * @OA\Get(
     *      path="/room",
     *      operationId="room-index",
     *      summary="Get list of rooms",
     *      description="Returns list of rooms",
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
        return Room::query()->paginate($request->get('limit',10));
    }

    /**
     * @OA\Get(
     *      path="/room/{id}",
     *      operationId="room-get",
     *      summary="Gets room",
     *      description="Returns specific room",
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
    public function get(Room $room)
    {
        return $room;
    }

    public function post(Request $request)
    {
        $request->validate([
            'number'=>'required|unique:rooms'
        ]);

        $room=Room::create($request->all());

        return response()->json($room,201);
    }

    public function put(Request $request, Room $room)
    {
        $room->update($request->all());

        return response()->json($room,200);
    }

    public function delete(Request $request, Room $room)
    {
        $room->delete();

        return response()->json(null,204);
    }
}
