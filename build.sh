composer install
php artisan sail:install --with=2
./vendor/bin/sail up -d
./vendor/bin/sail artisan migate:install
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=RoomTableSeeder
