<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Reservation::truncate();
        Room::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Creates 15 rooms with random size
        for ($i = 1; $i <= 3; $i++) {
            for($j=1;$j<=5;++$j){
                Room::create([
                    'number'=>$i*10+$j,
                    'beds'=>random_int(1,4)
                ]);
            }
        }
    }
}
