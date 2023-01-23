composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan migate:install
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=RoomTableSeeder
