<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Room",
 *     description="Available room data",
 *     type="object",
 * )
 */
class Room extends Model
{
    use HasFactory;

    protected $fillable = ['number','size'];

    public function reservation(){
        return($this->hasMany(Reservation::class));
    }

    static public function vacant(array $data=[]){
        $start=\DateTime::createFromFormat('Y-m-d',$data['start']);

        if(isset($data['stop'])){
            $stop=\DateTime::createFromFormat('Y-m-d',$data['stop']);
        }
        else {
            $stop=clone $start;
            $stop->add(new \DateInterval('P'.($data['days']??1).'D'));
        }

        $beds=$data['beds']??0;

        $query=self::query()
            ->select('rooms.*')
            ->where('rooms.beds','=',$beds)
            ->leftJoin('reservations',function($join) use ($start,$stop) {
                return ($join
                    ->on('rooms.id', '=', 'reservations.room_id')
                    ->whereDate('reservations.start','<',$stop->format('Y-m-d'))
                    ->whereDate('reservations.stop','>',$start->format('Y-m-d'))
                );
            })
            ->whereNull('reservations.id');

        return($query->paginate());
    }


}
