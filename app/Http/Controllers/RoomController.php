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
    public function get(Room $room)
    {
        return $room;
    }

    /**
     * @OA\Post(
     *      path="/room",
     *      operationId="room-post",
     *      summary="Creates new room",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Room")
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
    public function post(Request $request)
    {
        $request->validate([
            'number'=>'required|unique:rooms'
        ]);

        $room=Room::create($request->all());

        return response()->json($room,201);
    }

    /**
     * @OA\Put(
     *      path="/room/{id}",
     *      operationId="room-put",
     *      summary="Updates room data",
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
    public function put(Request $request, Room $room)
    {
        $room->update($request->all());

        return response()->json($room,200);
    }

    /**
     * @OA\Delete(
     *      path="/room/{id}",
     *      operationId="room-delete",
     *      summary="Deletes existing room",
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
    public function delete(Request $request, Room $room)
    {
        $room->delete();

        return response()->json(null,204);
    }
}
