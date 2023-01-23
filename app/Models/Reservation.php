<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     title="Reservation",
 *     description="Reservation data",
 *     type="object",
 * )
 * @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Reservation ID",
 *     readOnly="true"
 * ),
 * @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Name of person"
 * ),
 * @OA\Property(
 *     property="contact",
 *     type="string",
 *     description="Contact data"
 * ),
 * @OA\Property(
 *     property="start",
 *     type="string",
 *     format="date",
 *     description="Reservation start date",
 * ),
 * @OA\Property(
 *     property="stop",
 *     type="string",
 *     format="date",
 *     description="Reservation stop date",
 * ),
 * @OA\Property(
 *     property="created_at",
 *     type="string",
 *     format="date-time",
 *     description="Initial creation timestamp",
 *     readOnly="true"
 * ),
 * @OA\Property(
 *     property="updated_at",
 *     type="string",
 *     format="date-time",
 *     description="Last update timestamp",
 *     readOnly="true"
 * )
 */
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['room_id','start','stop','name','contact'];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    static public function reserve(array $data=[]){
        $start=\DateTime::createFromFormat('Y-m-d',$data['start']);

        if(isset($data['stop'])){
            $stop=\DateTime::createFromFormat('Y-m-d',$data['stop']);
        }
        else {
            $stop=clone $start;
            $stop->add(new \DateInterval('P'.($data['days']??1).'D'));
        }

        $beds=$data['beds']??0;
        $name=$data['name']??'';
        $contact=$data['contact']??'';

        return(DB::transaction(function() use ($start,$stop,$beds,$name,$contact){
            $room=Room::query()
                ->select('rooms.*')
                ->where('rooms.beds','=',$beds)
                ->leftJoin('reservations',function($join) use ($start,$stop) {
                    return ($join
                        ->on('rooms.id', '=', 'reservations.room_id')
                        ->whereDate('reservations.start','<',$stop->format('Y-m-d'))
                        ->whereDate('reservations.stop','>',$start->format('Y-m-d'))
                    );
                })
                ->whereNull('reservations.id')->first();

            if(!$room){
                return false;
            }

            $reservation=self::create([
                'room_id'=>$room->id,
                'start'=>$start->format('Y-m-d'),
                'stop'=>$stop->format('Y-m-d'),
                'name'=>$name,
                'contact'=>$contact
            ]);

            return($reservation);
        }));
    }
}
