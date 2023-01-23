composer install
cp .env.example .env
php artisan sail:install --with=mariadb
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:install
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=RoomTableSeeder
